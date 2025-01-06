

// business is licensed
document.addEventListener("DOMContentLoaded", function () {
    const toggleSelect = document.getElementById("isLicensed");
    const myDiv = document.getElementById("licenseDetails");

    toggleSelect.addEventListener("change", function () {
        if (this.value === "yes") {
            myDiv.style.display = "block"; // Show the div
        } else {
            myDiv.style.display = "none"; // Hide the div
        }
    });
});

// business is authorized

document.addEventListener("DOMContentLoaded", function () {
    const authSelect = document.getElementById("isAuthorized");
    const authDetails = document.getElementById("authorizationDetails");

    authSelect.addEventListener("change", function () {
        if (this.value === "yes") {
            authDetails.style.display = "block"; // Show the div
        } else {
            authDetails.style.display = "none"; // Hide the div
        }
    });
});


// country list
document.addEventListener("DOMContentLoaded", function () {
    const selectElement = document.getElementById("countryList");

    // Fetch countries from the Rest Countries API
    fetch("https://restcountries.com/v3.1/all")
        .then(response => response.json())
        .then(countries => {
            // Sort countries alphabetically by name
            countries.sort((a, b) =>
                a.name.common.localeCompare(b.name.common)
            );

            // Populate the select element
            countries.forEach(country => {
                const option = document.createElement("option");
                option.value = country.cca2; // ISO Alpha-2 code
                option.textContent = country.name.common; // Country name
                selectElement.appendChild(option);
            });
        })
        .catch(error => console.error("Error fetching countries:", error));
});


// retreive business


// document.getElementById('retrieveBusinessButton').addEventListener('click', function() {
//     const loadingDiv = document.getElementById('overlayDiv');


//     // Get values from input fields
//     const businssIdValue = document.getElementById('businessId').value;

//     // Show loading indicator
//     loadingDiv.style.display = 'block';

//     // Send asynchronous POST request
//     fetch('/gn-operations/business/fetch', { // Update this URL with your Laravel route
//         method: 'POST',
//         headers: {
//             'Accept': 'application/json',
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // For CSRF token
//         },
//         body: JSON.stringify({
//             businessId: businssIdValue, // Replace with actual POST data

//         })
//     })
//     .then(response => {
//         if (!response.ok) {

//             throw new Error('Network response was not ok ' + response.statusText);
//         }
//         return response.json();
//     })
//     .then(data => {

//         console.log(data);
//         populateTabs(data);
//         // Update div contents
//         // content1.textContent = data.content1 || 'No data for content1';
//         // content2.textContent = data.content2 || 'No data for content2';
//         // content3.textContent = data.content3 || 'No data for content3';
//     })
//     .catch(error => {
//         console.error('Error sending POST request:', error);
//         content1.textContent = 'Error sending data.';
//     })
//     .finally(() => {
//         // Hide loading indicator

//         loadingDiv.style.display = 'none';
//     });
// });


//  // Function to populate the tabs
// function populateTabs(data) {
//     // General Tab
//     const generalTab = document.getElementById('vert-tabs-general');
//     generalTab.innerHTML = `
//       <h5>Business Details</h5>
//       <p><strong>ID:</strong> ${data.id}</p>
//       <p><strong>Status:</strong> ${data.status}</p>
//       <p><strong>Created:</strong> ${new Date(data.created).toLocaleDateString()}</p>
//       <p><strong>Name:</strong> ${data.name.en}</p>
//     `;

//     // Brands Tab
//     const brandsTab = document.getElementById('vert-tabs-brands');
//     let brandsHtml = '<h5>Brands</h5>';
//     data.brands.forEach((brand) => {
//       brandsHtml += `
//         <p><strong>Name:</strong> ${brand.name.en}</p>
//         <p><strong>Logo:</strong> <img src="/path/to/logos/${brand.logo}" alt="${brand.name.en}" width="50" /></p>
//         <hr/>
//       `;
//     });
//     brandsTab.innerHTML = brandsHtml;

//     // User Tab
//     const userTab = document.getElementById('vert-tabs-user');
//     const user = data.user;
//     userTab.innerHTML = `
//       <h5>User Details</h5>
//       <p><strong>Name:</strong> ${user.name.first} ${user.name.last}</p>
//       <p><strong>Email:</strong> ${user.contact_info.primary.email}</p>
//       <p><strong>Phone:</strong> +${user.contact_info.primary.phone.country_code} ${user.contact_info.primary.phone.number}</p>
//     `;

//     // Entities Tab
//     const entitiesTab = document.getElementById('vert-tabs-entities');
//     let entitiesHtml = '<h5>Entities</h5>';
//     data.entities_info.forEach((entity) => {
//       entitiesHtml += `
//         <p><strong>Legal Name:</strong> ${entity.legal_name.en}</p>
//         <p><strong>Country:</strong> ${entity.country}</p>
//         <p><strong>License Number:</strong> ${entity.license.number}</p>
//         <p><strong>License Issuing Date:</strong> ${new Date(entity.license.issuing_date).toLocaleDateString()}</p>
//         <p><strong>License Expiry Date:</strong> ${new Date(entity.license.expiry_date).toLocaleDateString()}</p>
//         <hr/>
//       `;
//     });
//     entitiesTab.innerHTML = entitiesHtml;
// }

function retrieveBusiness() {
    const loadingDiv = document.getElementById('overlayDiv');

    // Get values from input fields
    const businssIdValue = document.getElementById('businessId').value;

    // Show loading indicator
    loadingDiv.style.display = 'block';

    // Send asynchronous POST request
    fetch('/gn-operations/business/fetch', { // Update this URL with your Laravel route
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // For CSRF token
        },
        body: JSON.stringify({
            businessId: businssIdValue, // Replace with actual POST data
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        console.log(data);
        const jsonTabContent = document.getElementById('json-tab-content');
        jsonTabContent.textContent = JSON.stringify(data, null, 2);
        populateTabs(data);
    })
    .catch(error => {
        console.error('Error sending POST request:', error);
        // Add error handling logic if needed
    })
    .finally(() => {
        // Hide loading indicator
        loadingDiv.style.display = 'none';
    });
}

// Function to populate the tabs (remains unchanged)
function populateTabs(data) {
    const generalTab = document.getElementById('vert-tabs-general');
    generalTab.innerHTML = `
      <h5>Business Details</h5>
      <p><strong>ID:</strong> ${data.id}</p>
      <p><strong>Status:</strong> ${data.status}</p>
      <p><strong>Created:</strong> ${new Date(data.created).toLocaleDateString()}</p>
      <p><strong>Name:</strong> ${data.name.en}</p>
    `;

    const brandsTab = document.getElementById('vert-tabs-brands');
    let brandsHtml = '<h5>Brands</h5>';
    data.brands.forEach((brand) => {
        brandsHtml += `
        <p><strong>Name:</strong> ${brand.name.en}</p>
        <p><strong>Logo:</strong> <img src="/path/to/logos/${brand.logo}" alt="${brand.name.en}" width="50" /></p>
        <hr/>
        `;
    });
    brandsTab.innerHTML = brandsHtml;

    const userTab = document.getElementById('vert-tabs-user');
    const user = data.user;
    userTab.innerHTML = `
      <h5>User Details</h5>
      <p><strong>Name:</strong> ${user.name.first} ${user.name.last}</p>
      <p><strong>Email:</strong> ${user.contact_info.primary.email}</p>
      <p><strong>Phone:</strong> +${user.contact_info.primary.phone.country_code} ${user.contact_info.primary.phone.number}</p>
    `;

    const entitiesTab = document.getElementById('vert-tabs-entities');
    let entitiesHtml = '<h5>Entities</h5>';
    data.entities_info.forEach((entity) => {
        entitiesHtml += `
        <p><strong>Legal Name:</strong> ${entity.legal_name.en}</p>
        <p><strong>Country:</strong> ${entity.country}</p>
        <p><strong>License Number:</strong> ${entity.license.number}</p>
        <p><strong>License Issuing Date:</strong> ${new Date(entity.license.issuing_date).toLocaleDateString()}</p>
        <p><strong>License Expiry Date:</strong> ${new Date(entity.license.expiry_date).toLocaleDateString()}</p>
        <hr/>
        `;
    });
    entitiesTab.innerHTML = entitiesHtml;
}




document.getElementById('retrieveButton').addEventListener('click', function() {

    const ptLoadingDiv = document.getElementById('ptOverlayDiv');


    // Get values from input fields
    const secretKeyValue = document.getElementById('ptSecretKey').value;

    // Show loading indicator
    ptLoadingDiv.style.display = 'block';

    // Send asynchronous POST request
    fetch('/in-operations/pt-details/fetch', { // Update this URL with your Laravel route
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // For CSRF token
        },
        body: JSON.stringify({
            ptSecretKey: secretKeyValue, // Replace with actual POST data

        })
    })
    .then(response => {
        if (!response.ok) {

            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {

        console.log(data);
        const jsonTabContent = document.getElementById('json-tab-content');
        jsonTabContent.textContent = JSON.stringify(data, null, 2);
        populatePTTabs(data);
        // Update div contents
        // content1.textContent = data.content1 || 'No data for content1';
        // content2.textContent = data.content2 || 'No data for content2';
        // content3.textContent = data.content3 || 'No data for content3';
    })
    .catch(error => {
        console.error('Error sending POST request:', error);
        content1.textContent = 'Error sending data.';
    })
    .finally(() => {
        // Hide loading indicator

        ptLoadingDiv.style.display = 'none';
    });
});

 // Function to populate the tabs
 function populatePTTabs(data) {
    // Payment Methods Tab
    const paymentMethodsTab = document.getElementById('vert-tabs-payment-methods');
    let paymentMethodsHtml = '<h5>Payment Methods</h5>';
    data.payment_methods.forEach(method => {
      paymentMethodsHtml += `
        <p><strong>Name:</strong> ${method.display_name}</p>
        <p><strong>Payment Type:</strong> ${method.payment_type}</p>
        <p><strong>Supported Currencies:</strong> ${method.supported_currencies.join(', ')}</p>
        <p><strong>Logo:</strong> <img src="${method.logos.light.svg}" alt="${method.display_name}" width="50" /></p>
        <hr />
      `;
    });
    paymentMethodsTab.innerHTML = paymentMethodsHtml;

    // Currencies Tab
    const currenciesTab = document.getElementById('vert-tabs-currencies');
    let currenciesHtml = '<h5>Supported Currencies</h5>';
    data.supported_currencies.forEach(currency => {
      currenciesHtml += `
        <p><strong>Name:</strong> ${currency.name} (${currency.symbol})</p>
        <p><strong>Rate:</strong> ${currency.rate}</p>
        <p><strong>Flag:</strong> <img src="${currency.flag}" alt="${currency.name}" width="30" /></p>
        <hr />
      `;
    });
    currenciesTab.innerHTML = currenciesHtml;
  }
  document.addEventListener('keydown', function (event) {
    if (event.key === 'Enter') {
      event.preventDefault(); // Prevent the default action (e.g., form submission or page reload)
      console.log('Enter key pressed, but prevented default action.');
    }
  });



// whitelist apple pay

  function applePayWhitelist() {
    const loadingDiv = document.getElementById('abOverlayDiv');

    // Get values from input fields
    const merchantId = document.getElementById('abMid').value;
    // Get values from input fields
    const brandId = document.getElementById('abBrandId').value;
            // Get values from input fields
    const domains = document.getElementById('abDomains').value;
    const requestType = document.getElementById('requestType').value;


    // Show loading indicator
    loadingDiv.style.display = 'block';

    // Send asynchronous POST request
    fetch('/in-operations/ab/whitelist', { // Update this URL with your Laravel route
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // For CSRF token
        },
        body: JSON.stringify({
            requestType: requestType,
            merchantId: merchantId, // Replace with actual POST data
            brandId: brandId,
            domains: domains
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        // Populate Full JSON Tab
        const jsonTabContent = document.getElementById('json-tab-content');
        jsonTabContent.textContent = JSON.stringify(data, null, 2);
        populateAbWhitelistTabs(data);
    })
    .catch(error => {
        console.error('Error sending POST request:', error);


        // Add error handling logic if needed
    })
    .finally(() => {
        // Hide loading indicator
        loadingDiv.style.display = 'none';
    });
}

// Function to populate the tabs (remains unchanged)
function populateAbWhitelistTabs(data) {
    // Populate Details Tab
    const detailsTab = document.getElementById('vert-tabs-details');
    detailsTab.innerHTML = `
        <h5>Details</h5>
        <p><strong>ID:</strong> ${data.id}</p>
        <p><strong>Status:</strong> ${data.status}</p>
        <p><strong>Created:</strong> ${new Date(data.created).toLocaleString()}</p>
        <p><strong>Live Mode:</strong> ${data.live_mode}</p>
        <p><strong>API Version:</strong> ${data.api_version}</p>
        <p><strong>Merchant:</strong> ${data.merchant}</p>
        <p><strong>Brand:</strong> ${data.brand}</p>
        <p><strong>Validate:</strong> ${data.validate}</p>
    `;

    // Populate Domain Names Tab
    const domainsTab = document.getElementById('vert-tabs-domains');
    let domainsHtml = '<h5>Domain Names</h5><ul>';
    data.domainNames.forEach((domain) => {
        domainsHtml += `<li>${domain}</li>`;
    });
    domainsHtml += '</ul>';
    domainsTab.innerHTML = domainsHtml;


}


// whitelist apple pay

function retreiveMerchant() {
    const loadingDiv = document.getElementById('merchantOverlayDiv');

    // Get values from input fields
    const merchantId = document.getElementById('merchantMid').value;


    // Show loading indicator
    loadingDiv.style.display = 'block';

    // Send asynchronous POST request
    fetch('/gn-operations/merchant/fetch', { // Update this URL with your Laravel route
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // For CSRF token
        },
        body: JSON.stringify({
            merchantId: merchantId, // Replace with actual POST data

        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        // Populate Full JSON Tab
        console.log(data);
        const jsonTabContent = document.getElementById('json-tab-content');
        jsonTabContent.textContent = JSON.stringify(data, null, 2);
        populateMerchantTabs(data);
    })
    .catch(error => {
        console.error('Error sending POST request:', error);


        // Add error handling logic if needed
    })
    .finally(() => {
        // Hide loading indicator
        loadingDiv.style.display = 'none';
    });
}

function populateMerchantTabs(data) {
    // Populate General Details
    const generalTab = document.getElementById("general-details");
    let generalDetailsHtml = "<h5>General Details</h5>";
    for (const [key, value] of Object.entries(data)) {
      if (typeof value !== "object" || Array.isArray(value)) {
        generalDetailsHtml += `<p><strong>${key}:</strong> ${
          Array.isArray(value) ? value.join(", ") : value
        }</p>`;
      }
    }
    generalTab.innerHTML = generalDetailsHtml;

    // Populate Terminals Tab
    const terminalsTab = document.getElementById("terminals-details");
    let terminalsHtml = "<h5>Terminals</h5>";
    data.terminals.forEach((terminal, index) => {
      terminalsHtml += `<h6>Terminal ${index + 1}</h6>`;
      for (const [key, value] of Object.entries(terminal)) {
        if (typeof value === "object" && !Array.isArray(value)) {
          terminalsHtml += `<p><strong>${key}:</strong> ${JSON.stringify(value)}</p>`;
        } else {
          terminalsHtml += `<p><strong>${key}:</strong> ${
            Array.isArray(value) ? value.join(", ") : value
          }</p>`;
        }
      }
      terminalsHtml += "<hr/>";
    });
    terminalsTab.innerHTML = terminalsHtml;

    // Populate Risk Tab
    const riskTab = document.getElementById("risk-details");
    let riskHtml = "<h5>Risk Details</h5>";
    for (const [key, value] of Object.entries(data.risk)) {
      riskHtml += `<p><strong>${key}:</strong> ${
        Array.isArray(value) ? JSON.stringify(value, null, 2) : value
      }</p>`;
    }
    riskTab.innerHTML = riskHtml;

    // Populate Operator Tab
    const operatorTab = document.getElementById("operator-details");
    let operatorHtml = "<h5>Operator Details</h5>";
    for (const [key, value] of Object.entries(data.operator)) {
      operatorHtml += `<p><strong>${key}:</strong> ${
        typeof value === "object" && !Array.isArray(value)
          ? JSON.stringify(value, null, 2)
          : value
      }</p>`;
    }
    operatorTab.innerHTML = operatorHtml;

    // Populate Data Status Tab
    const dataStatusTab = document.getElementById("data-status-details");
    let dataStatusHtml = "<h5>Data Status</h5>";
    for (const [key, value] of Object.entries(data.data_status)) {
      dataStatusHtml += `<p><strong>${key}:</strong> ${value}</p>`;
    }
    dataStatusTab.innerHTML = dataStatusHtml;

    // Populate Data Verification Tab
    const dataVerificationTab = document.getElementById("data-verification-details");
    let dataVerificationHtml = "<h5>Data Verification</h5>";
    for (const [key, value] of Object.entries(data.data_verification)) {
      dataVerificationHtml += `<p><strong>${key}:</strong> ${value}</p>`;
    }
    dataVerificationTab.innerHTML = dataVerificationHtml;
  }

  // Example usage


