import puppeteer from "puppeteer";

(async () => {
    // Launch the browser and open a new blank page
    const browser = await puppeteer.launch({ headless: false });
    const page = await browser.newPage();

    // await page.setGeolocation({ latitude: -8.65, longitude: 115.216667 });

    await page.evaluateOnNewDocument(function () {
        navigator.geolocation.getCurrentPosition = function (cb) {
            setTimeout(() => {
                cb({
                    coords: {
                        accuracy: 21,
                        altitude: null,
                        altitudeAccuracy: null,
                        heading: null,
                        latitude: -8.65,
                        longitude: 115.216667,
                        speed: null,
                    },
                });
            }, 1000);
        };
    });

    // Navigate the page to a URL
    await page.goto("https://www.logammulia.com/id/harga-emas-hari-ini");

    // Set screen size
    await page.setViewport({ width: 1080, height: 1024 });

    await page.waitForSelector(".swal-modal");

    await Promise.all([
        page.click(".swal-button--confirm"),
        page.waitForNavigation({ waitUntil: "load" }), // The promise resolves after navigation has finished
    ]);
    //
    const name = await page.evaluate(
        (el) => el.textContent,
        await page.$(`table > tbody > tr:nth-child(11) > td:nth-child(2)`),
    );

    // new Promise((r) => setTimeout(r, 5000));
    // Print the full title
    console.log('The title of this blog post is "%s".', name);

    await browser.close();
})();
