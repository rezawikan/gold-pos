import puppeteer from "puppeteer";

(async () => {
    // Launch the browser and open a new blank page
    const browser = await puppeteer.launch({
        headless: false,
        // userDataDir:
        //     "C:\\Users\\rezaw\\AppData\\Local\\Google\\Chrome\\User Data",
    });
    const page = await browser.newPage();
    const buttonSubmitLocationSelector = "input[value='SIMPAN PERUBAHAN']";
    const buttonLocationSelector = ".btn-location";
    const select2Selector = ".select2-basic";

    // await page.setGeolocation({ latitude: -8.65, longitude: 115.216667 });

    // Set the user agent
    // await page.setUserAgent(
    //     "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36",
    // );

    // Navigate the page to a URL
    await page.goto("https://www.logammulia.com/id/harga-emas-hari-ini");

    // await page.evaluateOnNewDocument(function () {
    //     navigator.geolocation.getCurrentPosition = function (cb) {
    //         setTimeout(() => {
    //             cb({
    //                 coords: {
    //                     accuracy: 21,
    //                     altitude: null,
    //                     altitudeAccuracy: null,
    //                     heading: null,
    //                     latitude: -8.65,
    //                     longitude: 115.216667,
    //                     speed: null,
    //                 },
    //             });
    //         }, 1000);
    //     };
    // });

    await page.evaluate(async () => {
        await new Promise(function (resolve) {
            setTimeout(resolve, 5000);
        });
    });

    // Set screen size
    await page.setViewport({ width: 1080, height: 1024 });

    await page.waitForSelector(buttonLocationSelector);
    await page.click(buttonLocationSelector);
    await page.waitForSelector(select2Selector);

    // Delay mode
    // await page.evaluate(async () => {
    //     await new Promise(function (resolve) {
    //         setTimeout(resolve, 5000);
    //     });
    // });

    await page.evaluate(() => {
        $(".select2-basic").select2("open");
        $(".select2-basic").val("DPS01").trigger("change");
        $(".select2-basic").select2("close");
    });

    await Promise.all([
        page.waitForSelector(buttonSubmitLocationSelector),
        page.click(buttonSubmitLocationSelector),
        page.waitForNavigation({ waitUntil: "load" }), // The promise resolves after navigation has finished
    ]);

    // It's only for geo location
    //
    // await page.evaluate(async () => {
    //     await new Promise(function (resolve) {
    //         setTimeout(resolve, 5000);
    //     });
    // });
    // await page.waitForSelector(".swal-modal");
    //
    // await Promise.all([
    //     page.click(".swal-button--confirm"),
    //     page.waitForNavigation({ waitUntil: "load" }), // The promise resolves after navigation has finished
    // ]);

    const emasBatangan = await page.evaluate(() => {
        const tbody = document.querySelectorAll("table > tbody > tr");
        let data = Array.from(tbody)
            .slice(1)

            .map((row, index) => {
                const cells = row.querySelectorAll("td");
                if (cells.length !== 3) return null;
                return Array.from(cells).map((cell, index) =>
                    cell.textContent.trim(),
                );
            })
            .filter((row) => row !== null);

        data = data.map((x) => {
            const cleanedString = x[0].replace("gr", "").trim();
            return {
                grams: parseFloat(cleanedString),
                price: parseInt(x[1].replace(/,/g, "")),
                price_with_fee: parseInt(x[2].replace(/,/g, "")),
            };
        });

        const batangan = {
            title: tbody[1].querySelector("th").textContent,
            data: data.slice(0, 9),
        };

        const giftSeries = {
            title: tbody[14].querySelector("th").textContent,
            data: data.slice(13, 15),
        };

        return {
            batangan: batangan,
            gift_series: giftSeries,
        };
    });

    // Navigate the page to a URL
    await page.goto("https://www.logammulia.com/id/sell/gold");

    await page.evaluate(async () => {
        await new Promise(function (resolve) {
            setTimeout(resolve, 5000);
        });
    });

    await page.waitForSelector(buttonLocationSelector);
    await page.click(buttonLocationSelector);
    await page.waitForSelector(select2Selector);

    await page.evaluate(() => {
        $(".select2-basic").select2("open");
        $(".select2-basic").val("DPS01").trigger("change");
        $(".select2-basic").select2("close");
    });

    await Promise.all([
        page.waitForSelector(buttonSubmitLocationSelector),
        page.click(buttonSubmitLocationSelector),
        page.waitForNavigation({ waitUntil: "load" }), // The promise resolves after navigation has finished
    ]);

    const buybackPrice = await page.evaluate(() => {
        const price = document.querySelector(
            ".chart-info > .ci-child > .value",
        );

        return price.textContent.replace(/Rp|,/g, "").trim();
    });

    let result = JSON.stringify({
        ...emasBatangan,
        buyback_price: buybackPrice,
    });

    console.log(result);

    await browser.close();
})();
