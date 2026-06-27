const { chromium } = require('playwright');
(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();
  await page.goto('https://www.shotikotsikura.com/hostilenoise/', { waitUntil: 'domcontentloaded' });
  await page.waitForTimeout(3000); // Give it time to load dynamic elements
  const imgs = await page.evaluate(() => {
    return Array.from(document.querySelectorAll('img')).map(img => img.src).filter(src => src && src.includes('pixieset'));
  });
  console.log(JSON.stringify([...new Set(imgs)], null, 2));
  await browser.close();
})();
