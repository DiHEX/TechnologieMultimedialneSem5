<h2>Chatbot</h2>

<div id="chatbot-history" class="row">
    <div class="col-md-9">
        <strong>Chatbot:</strong>
        <p>Witaj, zadaj mi pytanie, a ja postaram się odpowiedzieć.</p>
    </div>

    <div class="col-md-3">
        <img src="avatar.png" style="width: 100px;" />
    </div>

</div>

<form class="row gx-3 gy-2 align-items-center" style="margin-top: 5px; margin-bottom: 20px;" id="chatbot-form">
    <div class="col-sm-8">
        <label class="visually-hidden" for="question">Twoje pytanie</label>
        <input type="text" class="form-control" placeholder="Twoje pytanie" id="question" name="question">
    </div>
    <div class="col-sm-4">
        <button type="submit" class="btn btn-primary">Zapytaj bota</button>
    </div>
</form>

<script>
    // Mapuje nazwy podstron na słowa kluczowe, które będą rozpoznawane przez chatbota
    // Na przykład jeśli użytkownik wpisze "o firmie", to chatbot odpowie informacjami o podstronie "about-company"
    const responseMap = {
        "about-company": ["o firmie", "opowiedz o sobie"],
        "contact": ["kontakt", "dane kontaktowe"],
        "how-to-reach-us": ["jak dojechać", "mapa", "lokalizacja", "gdzie"],
        "offers": ["oferty", "oferta"]
    }

    document.getElementById("chatbot-form").addEventListener("submit", e => {
        e.preventDefault();
        const question = document.getElementById("question").value;
        const chatbotHistory = document.getElementById("chatbot-history");

        let randomQuestionId = Math.random().toString(36).slice(2, 7);
        let response = "Przepraszam, nie rozumiem pytania. Wpisz /h żeby zobaczyć dostępne słowa kluczowe.";
        let foundSubpage = null;

        if (question === "/h") {
            response = "Dostępne słowa kluczowe to: " + Object.values(responseMap).join(", ");
        }
        for (const [subpage, keywords] of Object.entries(responseMap)) {
            if (keywords.some(keyword => question.toLowerCase().includes(keyword))) {
                response = `Ładowanie informacji na temat ${subpage}...`;
                foundSubpage = subpage;
                break;
            }
        }

        const chatbotResponse = document.createElement("div");
        chatbotResponse.innerHTML = `
            <div>
                <strong>Użytkownik:</strong>
                <p>${question}</p>
            </div>
            <div>
                <strong>Chatbot:</strong>
                <p id="question-${randomQuestionId}">${response}</p>
            </div>
        `;

        chatbotHistory.appendChild(chatbotResponse);
        document.getElementById("question").value = "";
        window.scrollTo(0, document.body.scrollHeight);

        // Pobierz treść podstrony z serwera i wyświetl ją w odpowiedzi chatbota
        if (foundSubpage !== null) {
            fetch(`/zadanie16/actions/get-subpage-content.php?subpage=${foundSubpage}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById(`question-${randomQuestionId}`).innerHTML = data;
                    window.scrollTo(0, document.body.scrollHeight);

                    let formData = new FormData();
                    formData.append("question", question);
                    formData.append("response", data);
                    fetch("/zadanie16/actions/add-chatbot-log.php", {
                        method: "POST",
                        body: formData
                    });
                });
        } else {
            let formData = new FormData();
            formData.append("question", question);
            formData.append("response", response);
            fetch("/zadanie16/actions/add-chatbot-log.php", {
                method: "POST",
                body: formData
            });
        }
    });
</script>
