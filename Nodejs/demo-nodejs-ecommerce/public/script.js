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

async function checkout() {
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

  document.querySelector("#paymentStatus").innerText =
    "Vérification des données";

  const response = await axios.post("./requestPayment", requestBody)

  updatePaymentStatus(response.data)

  launchStatusChecking()
}


function updatePaymentStatus(transactionResponse) {
  console.log(transactionResponse);
  let statusToShow = "En cours : ";
  if (transactionResponse.success) {
    statusToShow = "Réussi : ";
  } else if (transactionResponse.error) {
    statusToShow = "Erreur : ";
  }

  if (transactionResponse.transaction) {
    statusToShow += transactionResponse.transaction.statusMessage;
  }

  document.querySelector("#paymentStatus").innerText = statusToShow;
}


function launchStatusChecking() {
  const intervalId = setInterval(async () => {
    const response = await axios.get("./status")
    updatePaymentStatus(response.data)
    if (!response.data.pending) {
      clearInterval(intervalId)
    }

  }, 3000)
}