function showCheckout(productName, amount, pictureUrl, description) {
  const checkoutModal = document.querySelector("#checkoutModal");
  document.querySelector("#productName").innerText = productName;
  document.querySelector("#productAmount").innerText = amount;
  document.querySelector("#pictureUrl").setAttribute("src", pictureUrl);
  document.querySelector("#productDescription").innerText = description;

  checkoutModal.style.display = "flex";
}

function closeCheckout() {
  const checkoutModal = document.querySelector("#checkoutModal");
  checkoutModal.style.display = "none";
}

function checkout() {
  const phoneNumber = document.querySelector("#phoneNumberInput").value;
  const firstName = document.querySelector("#firstNameInput").value;
  const lastName = document.querySelector("#lastNameInput").value;
  const amount = document.querySelector("#productAmount").innerText;

  const requestBody = {
    firstName: firstName,
    lastName: lastName,
    phoneNumber: phoneNumber,
    amount: amount,
  };

  const xhr = new XMLHttpRequest();
  xhr.open(
    "POST",
    "http://localhost/demo-php-ecommerce/requestPayment.php",
    true
  );
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.onreadystatechange = () => {
    if (!xhr.responseText) return;
    const lastStatus = getLastStatusFromRequestResponse(xhr.responseText);
    updatePaymentStatus(lastStatus);
  };
  xhr.send(JSON.stringify(requestBody));

  document.querySelector("#paymentStatus").innerText =
    "Vérification des données";
}

function getLastStatusFromRequestResponse(requestResponse) {
  const allResponses = requestResponse.split("NewStatus");
  const lastResponse = allResponses[allResponses.length - 1];
  return JSON.parse(lastResponse);
}

function updatePaymentStatus(transactionResponse) {
  console.log(transactionResponse);
  let statusToShow = "En cours : ";
  if (transactionResponse.success) {
    statusToShow = "Réussi : ";
  } else if (transactionResponse.error) {
    statusToShow = "Erreur : ";
  }

  statusToShow += transactionResponse.transaction.statusMessage;

  document.querySelector("#paymentStatus").innerText = statusToShow;
}
