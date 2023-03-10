//!  ---- Fonctions

    /**
     * 
     * @param {NodeList} elements liste des elements a afficher et trier
     * @param {Node} container conteneur des elements
     * Reaffiche tout les elements et supprime le message d'erreur
     */
    function resetSearch(elements, container){
        //? initialisation afficher tout les elements
        
            elements.forEach(element => {
                element.removeAttribute("style");
            });

            container.removeAttribute("style");

            if(document.querySelector("#noResult")){

                document.querySelector("#noResult").remove();
            }
    }


    /**
     * 
     * @param {NodeList} elements liste des elements a afficher et trier
     * @param {Object} data resultat de la requete ajax
     * @param {Node} container conteneur des elements
     * Affiche les elements correspondant a la recherche en fonction des données de la requete ajax et 
     * affiche un message d'erreur si aucun resultat n'est trouvé
     */
    function match(elements, data, container){
        
        //? initialisation afficher tout les elements
            resetSearch(elements,container)
            
        if ( data.data == 0) {
            elements.forEach(element => {
                element.style.display = "none"

                
            });

            noResult = document.createElement("div");
            noResult.innerHTML = "<p>"+data.message+"</p><a href='#' id='searchReset' class='bouton bouton--secondary'> Retour</button>";
            noResult.setAttribute('class','accueil__search__noResult');
            noResult.setAttribute('id','noResult');
            container.style.placeItems = "center";
            container.style.gridTemplateColumns = "repeat(auto-fit,minmax(300px,1fr))";
            container.append(noResult);
            

            let resetButton = document.querySelector("#searchReset");
            resetButton.addEventListener("click",(e)=>{
                e.preventDefault()
                resetSearch(elements,container)
            })
        } else {
            
            //? tri en fonction des données
            elements.forEach(element => {
                let id = element.getAttribute('id')
                if (! data.data.includes(+id)) {
                    element.style.display = "none"
                }else{
                    element.removeAttribute("style");

                }
            })
        }
    }



    /**
     * 
     * @param {Node} form formulaire de recherche
     * @param {String} link lien de la requete ajax
     * @param {NodeList} elements liste des elements a afficher et trier
     * @param {Node} container conteneur des elements
     * 
     * Envoie les données du formulaire de recherche en ajax et affiche les elements correspondant a la recherche
     * 
     */
    async function fetchUser(form,link,elements,container) {
        const formData = new FormData(form)
        const response = await fetch(
            link, { 
                method: 'POST', 
                headers: { 
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: new URLSearchParams(formData).toString()
            }
        ); 
        if (!response.ok) {
            
            alert("une erreur est survenue essayer plus tard")

        } else {

            let data = await response.json()
            console.log(data.data)

            match(elements, data, container);
        }

        

    }