document.addEventListener("DOMContentLoaded", function () {

    const paymentMethod = document.getElementById("payment_method");

    if (!paymentMethod) {
        console.error("payment_method select not found");
        return;
    }

    paymentMethod.addEventListener("change", function () {

        let pm = this.value;

        let upi = document.getElementById("upi");
        let card = document.getElementById("card");
        let net = document.getElementById("netbanking");

        if (upi) upi.style.display = "none";
        if (card) card.style.display = "none";
        if (net) net.style.display = "none";

        if (pm === "UPI" && upi) upi.style.display = "block";
        if (pm === "Card" && card) card.style.display = "block";
        if (pm === "Net Banking" && net) net.style.display = "block";
    });

});
