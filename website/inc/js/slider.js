const sliders = document.getElementsByClassName("slider");

for (let i = 0; i < sliders.length; i++) {
    //Per ogni slider nel documento, prendo i suoi figli
    const slider = sliders[i].children;
    let slide;
    let preButton;
    let nextButton;
    //Trovo dopo quali sono le immagini a cui applicare lo slide (id = "slider") e i bottoni per lo sliding (id = "prev" e id = "next")
    for (let i = 0; i < slider.length; i++) {
        const list = slider[i].classList;
        if(list.contains("carousel-inner")) {
            slide = slider[i];
        } else if (list.contains("carousel-control-prev")) {
            preButton = slider[i];
        } else if (list.contains("carousel-control-next")) {
            nextButton = slider[i];
        }
    }

    //Prendo i figli di slide, ovvero le immagini
    const images = slide.children;
    
    //Add of a margin right to all the imgs but the last one
    for (let i = 0; i<images.length-1; i++) {
        images[i].classList.add("me-3");
    }

    //Se ci sono più di 4 immagini allora applico lo sliding, altrimenti le visualizzo normalmente
    if (images.length > 4) {
        //Rimuovo il display:hidden dai bottoni e metto l'inline-block, attraverso le classi del bootstrap
        preButton.classList.remove("d-none");
        preButton.classList.add("d-inline-block");

        nextButton.classList.remove("d-none");
        nextButton.classList.add("d-inline-block");

        //Visualizzo le immagine al centro del div
        slide.classList.add("text-center");

        //Rendo invisibili tutte le immagini oltre la terza e aggiungo alla prima del margine a sinistra
        images[0].classList.add("ms-3");

        //Inizializzo degli indici per sapere automaticamente quali sono le immagini visibili, che all'inizio saranno le prime 3
        let first = 0;
        let second = 1;
        let third = 2;

        for (let i = 0; i < images.length; i++) {
            if (i > 2) {
                images[i].classList.add("d-none");
            } else {
                images[i].classList.add("d-inline");
            }
        }

        //Aggiungo margine destro all'ultima immagine, che non serviva nel caso di meno di 5 immagini
        images[images.length-1].classList.add("me-3");

        preButton.addEventListener("click", () => {
            if (first-1 >= 0) {
                //Se si può andare a sinistra, rendo invisibile l'ultima immagine attualmente visibile e vado indietro
                images[third].classList.remove("d-inline");
                images[third].classList.add("d-none");
                //Tolgo il margine a sinistra della prima immagine e la do alla nuova prima immagine
                images[first].classList.remove("ms-3");

                //Diminuisco gli indici, poichè mi sposto a sinistra di 1 immagine
                first--;
                second--;
                third--;

                //Faccio comparire l'immagine precedente a quelle che erano visibili prima
                images[first].classList.remove("d-none");
                images[first].classList.add("d-inline");
                images[first].classList.add("ms-3")
            }            
        });

        nextButton.addEventListener("click", () => {
            //Rendo invisibile la prima immagine che era visibile prima per rendere visiva la prossima
            images[first].classList.remove("d-inline");
            images[first].classList.add("d-none");
            //Tolgo il margine a sinistra della prima immagine e la do alla nuova prima immagine
            images[first].classList.remove("ms-3");

            //Aumento di 1 gli indici, poichè mi sposto a destra di 1 immagine.
            first++;
            second++;
            third++;

            if (third >= images.length) {
                //Se ho raggiunto la fine delle immagini e provo ad andare a destra, faccio diventare invisibili tutte le immagini attualmente visibili e rendo visibili le prime 3
                images[first].classList.remove("d-inline");
                images[first].classList.add("d-none");

                images[second].classList.remove("d-inline");
                images[second].classList.add("d-none");
                first = 0;
                second = 1;
                third = 2;

                images[first].classList.remove("d-none");
                images[first].classList.add("d-inline-block");
                images[first].classList.add("ms-3");

                images[second].classList.remove("d-none");
                images[second].classList.add("d-inline-block");
            }

            images[third].classList.remove("d-none");
            images[third].classList.add("d-inline-block");
            images[first].classList.add("ms-3");

        });
    }
}