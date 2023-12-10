fetch('https://restcountries.com/v3.1/all')
.then(response => response.json())
.then(data => {
    const countriesDropdown = document.getElementById('countries');

    // Sort countries alphabetically by common name
    const sortedCountries = data.sort((a, b) => a.name.common.localeCompare(b.name.common));

    // Iterate through the sorted data and create options for the dropdown
    sortedCountries.forEach(country => {
        const option = document.createElement('option');
        option.textContent = country.name.common;
        countriesDropdown.appendChild(option);
    });
})
.catch(error => console.error('Error fetching countries:', error));