import re

header_path = "header.php"
footer_path = "footer.php"
prog_path = "programme/index.php"

with open(header_path, "r") as f:
    header = f.read()

with open(footer_path, "r") as f:
    footer = f.read()

with open(prog_path, "r") as f:
    prog = f.read()

# Render header
header = re.sub(r'<\?php.*?title \?; \?>', '', header, flags=re.DOTALL) # remove top block? No, easier to just manually replace

# Let's extract the HTML part of header
html_start = header.find('<!DOCTYPE html>')
header_html = header[html_start:]

# Variables for programme page
title = "Programme — HOSTILE NOISE"
og_title = "Programme — HOSTILE NOISE"
og_desc = "Full programme for HOSTILE NOISE — Friction in Design, Art and Technology. 18 April 2026, Rooms, Tbilisi."
og_image = "og-image.png"

# Replace variables in header HTML
header_html = header_html.replace("<?php echo $title; ?>", title)
header_html = header_html.replace("<?php echo $og_t; ?>", og_title)
header_html = header_html.replace("<?php echo $og_d; ?>", og_desc)
header_html = header_html.replace("<?php echo str_replace(' ', '%20', $og_i); ?>", og_image.replace(' ', '%20'))
header_html = header_html.replace("<?php echo $home ? 'website' : 'article'; ?>", "article")

# Handle the <?php if ($home): ?> block in header
home_block_pattern = re.compile(r'<\?php if \(\$home\): \?>(.*?)<\?php else: \?>(.*?)<\?php endif; \?>', re.DOTALL)
def home_replacer(match):
    return match.group(2) # we want the 'else' block

header_html = home_block_pattern.sub(home_replacer, header_html)

# Now process the programme page
prog_content = prog
# remove <?php ... ?> at the top
prog_content = re.sub(r"<\?php\n.*?\n\?>", "", prog_content, count=1, flags=re.DOTALL)
# replace includes
prog_content = prog_content.replace("<?php include '../header.php'; ?>\n", "")
prog_content = prog_content.replace("<?php include '../footer.php'; ?>", footer)

# Combine
final_html = header_html + prog_content

with open("programme/index.html", "w") as f:
    f.write(final_html)

print("Generated programme/index.html")
