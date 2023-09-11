const searchInput = document.getElementById('searchInput');
const suggestionsList = document.getElementById('suggestions');

searchInput.addEventListener('input', function() {
    const inputValue = this.value;

    fetch(
            `https://api.tomtom.com/search/2/search/${encodeURIComponent(inputValue)}.json?key=tjBiGEAUGDCzaAZB0pAlxSemjpDfgVP1&countrySet=IT`
        )
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            const addresses = data.results;
            console.log(addresses);

            // Rimuovi i suggerimenti precedenti
            suggestionsList.innerHTML = '';

            // Mostra gli indirizzi suggeriti nell'autocompletamento
            addresses.forEach(function(address) {
                suggestionsList.style.display = 'block';
                const suggestion = document.createElement('li');
                suggestion.textContent = address.address.freeformAddress;
                console.log(addresses.length);

                suggestion.addEventListener('click', function() {
                    // Aggiungi il valore dell'indirizzo selezionato all'input di ricerca
                    searchInput.value = address.address.freeformAddress;
                    const indirizzo = document.getElementById('resultField');
                    const latitudine = document.getElementById('resultFieldLA');
                    const longitudine = document.getElementById('resultFieldLO');
                    indirizzo.value = address.address.freeformAddress;
                    latitudine.value = address.position.lat;
                    longitudine.value = address.position.lon;
                    suggestionsList.style.display = 'none';
                    console.log(latitudine.value , longitudine.value ,"siamo qui");
                });

                suggestionsList.appendChild(suggestion);
            });
        })
        .catch(function(error) {
            console.error(error);
        });
});