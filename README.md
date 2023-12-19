
https://partielcharles.jeremyduc.com/


    <div>

        <h1>Routes de base de L'api</h1>

        <p>pour se créer un compte la route est juste /register </p>
        <p>Avant toute autre requete mettre le /api</p>

        <hr>

        <h2>Routes</h2>
        <hr>
        <p>Enregistrement (Register)</p>
        <p>Méthode HTTP : POST</p>
        <p>Chemin : /register</p>
        <p>Cette route permet aux utilisateurs de créer un compte en fournissant un nom d'utilisateur (username) et un mot de passe (password).</p>
        <hr>

        <p> Connexion (login)</p>
        <p>Méthode HTTP : POST</p>
        <p>Chemin : /login_check</p>
        <p>Description : Utilisée pour l'authentification, cette route permet aux utilisateurs de se connecter en fournissant un nom d'utilisateur (username) et un mot de passe (password).</p>

        <hr>
        <p> Deconnexion (logout)</p>
        <p>Méthode HTTP : GET</p>
        <p>Chemin : /logout</p>

        <hr>

        <p>Voir tous les Evenements Public</p>
        <p>Méthode HTTP : GET</p>
        <p>Chemin : /all/public/event</p>

        <hr>

        <p>Créer un evenement public</p>
        <p>Méthode HTTP : POST</p>
        <p>Chemin : /public/event/create</p>
        <p>exemple de requete : {"place":"lala",
                                "description":"lala",
                                "startof": "2023-12-20",
                                "endof": "2023-12-21",
                                "privateplace":"0",
                                "participant": ["5"]} pour le ou les  participants il faut mettre l'id de l'utilisateur souhaité</p>

        <hr>

        <p>Recuperer tous les participants d'un evenement public</p>
        <p>Méthode HTTP : GET</p>
        <p>Chemin : /public/event/getParticipants/{id}</p>
        <p>description : mettre l'id de l'evenement souhaité</p>

        <hr>

        <p>Créer un evenement Privé</p>
        <p>Méthode HTTP : POST</p>
        <p>Chemin : /create/private/event</p>
        <p>exemple : {"place":"lala",
            "description":"lala",
            "startof": "2023-12-20",
            "endof": "2023-12-21",
            "privateplace":"1",
            "participant": ["5"]} pour le ou les  participants il faut mettre l'id de l'utilisateur souhaité</p>

        <hr>

        <p>Recuperer tous ces evenements privé</p>
        <p>Méthode HTTP : GET</p>
        <p>Chemin : /public/event/getParticipants/{id}</p>
        <p>description : mettre l'id de l'utilisateur</p>

        <hr>

        <p>Invité un utilisateur dans un evenement privé</p>
        <p>Méthode HTTP : POST</p>
        <p>Chemin : /private/event/invite/{id}/{userId}</p>
        <p>description : dans le premier id mettre l'id de l'evenement puis dans le second mettre celui de l'utilisateur que l'on veut invité</p>

        <hr>

        <p>Changé les date de ton évenement</p>
        <p>Méthode HTTP : PUT</p>
        <p>Chemin : /edit/private/event/{id}</p>
        <p>description : mettre l'id dans l'url puis dans la requete mettre {"startof":"la date de votre choix","endof":"une autre date"</p>

        <hr>

        <p>Recuperer tous les profiles</p>
        <p>Méthode HTTP : GET</p>
        <p>Chemin : /allprofiles</p>

        <hr>

        <p>Recuperer toutes ces invitations</p>
        <p>Méthode HTTP : GET</p>
        <p>Chemin : /all/invitations</p>


        <hr>

        <p>accepter une invitations</p>
        <p>Méthode HTTP : PUT</p>
        <p>Chemin : /invitations/accept/{id}</p>
        <p>description: mettre l'id de l'inviations que l'on veut accepter</p>

        <hr>

        <p>creer une contribution</p>
        <p>Méthode HTTP : POST</p>
        <p>Chemin : /create/contribution/{eventId}</p>
        <p>description: mettre l'id de l'evenement dans l'url et mettre une product en requete</p>

        <hr>

        <p>creer une Suggestion</p>
        <p>Méthode HTTP : POST</p>
        <p>Chemin : /add/suggestion/{eventId}</p>
        <p>description: mettre l'id de l'evenement public dans l'url et mettre une product en requete</p>

        <p>accepter une Suggestion</p>
        <p>Méthode HTTP : POST</p>
        <p>Chemin : /accept/suggestion/{suggestionId}</p>
        <p>description: mettre l'id de lal suggestion dans l'url</p>

    </div>
{% endblock %}
