function validateLoginForm() {
    const emailVagyNev = document.getElementById("emailVagyNev").value.trim();
    const jelszo = document.getElementById("jelszo").value.trim();

    if (emailVagyNev === "" || jelszo === "") {
        alert("Minden mezőt ki kell tölteni!");
        return false;
    }

    if (jelszo.length < 6) {
        alert("A jelszónak legalább 6 karakter hosszúnak kell lennie!");
        return false;
    }

    return true; // mehet a submit
}