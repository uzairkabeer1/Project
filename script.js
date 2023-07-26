document
  .getElementById("getQuoteBtn")
  .addEventListener("click", async function () {
    const quote = await getQuote();
    const quoteObj = JSON.parse(quote);
    document.getElementById("favIcon").style.display = "block";
    document.getElementById("quoteText").innerHTML =
      "'" + quoteObj.content + "'";
    document.getElementById("quoteAuthor").innerHTML =
      "<strong>" + quoteObj.originator.name + "</strong>";
    document.getElementById("quoteInput").value = quoteObj.content;
    document.getElementById("authorInput").value = quoteObj.originator.name;
  });

const getQuote = async () => {
  const url = "https://quotes15.p.rapidapi.com/quotes/random/";
  const options = {
    method: "GET",
    headers: {
      "X-RapidAPI-Key": "79f95ac61dmshb80731a069ceea9p155477jsne3fc547fb186",
      "X-RapidAPI-Host": "quotes15.p.rapidapi.com",
    },
  };

  try {
    const response = await fetch(url, options);
    const result = await response.text();
    return result;
  } catch (error) {
    console.error(error);
  }
};

document.getElementById("addIcon").addEventListener("click", async function () {
  document.getElementById("favBtn").click();
});
