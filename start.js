var cnt = 0;
setInterval(function () {
    console.clear();
    console.log("░░░░░░░░░░░░░░░░░░░░░░░░░");
    console.log("░     Durleo.com.br     ░");
    console.log("░░░░░░░░░░░░░░░░░░░░░░░░░");
    console.log(" ");
    console.log(" ");
    switch (cnt) {
        case 0:
            console.log("Monitorando Impressão");
            cnt = 1;
            break;
        case 1:
            console.log("Monitorando Impressão.");
            cnt = 2;
            break;
        case 2:
            console.log("Monitorando Impressão...");
            cnt = 0;
            break;
    }
}, 500);