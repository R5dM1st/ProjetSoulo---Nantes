# Documentation des routes de l'API

## Authentification

### POST /login

```json
{
  "email": "string",
  "password": "string"
}
```

Permet de se connecter à l'application.
Retourne un token d'authentification.

```json
{
  "session_id": "string"
}
```

### POST /register

```json
{
  "email": "string",
  "password": "string",
  "nom": "string",
  "prenom": "string"
}
```

## Les requêtes authentifiées nécessitent un token d'authentification dans le header de la requête

```json
{
    "Authorization", "Bearer " + token
}
```

### GET /table

Permet de récupérer la table de plongée




### GET /plongee/profile
Get the default profile

### GET /plongee/profile?profile_id=int
Get the profile with the given id

### GET /plongee/profile (authentifié)
Get the profile of the user + default profile




### POST /plongee/profile
Add a new profile

```json
{
  "nom": "string",
  "vitesse_desc": "string",
  "vitesse_asc": "string",
  "respiration": "string"
}
```

### DELETE /plongee/profile?id=int
Delete the profile with the given id

### PUT /plongee/profile?id=int
Update the profile with the given id

```json
{
  "nom": "string",
  "vitesse_desc": "string",
  "vitesse_asc": "string",
  "respiration": "string"
}
```
/!\ Ne pas oublier the auth=true avec ajaxRequest

### POST /plongee/equipement
Add an equipement

```json
{
  "nom": "string",
  "contenance": "string",
  "pression": "string"
}
```
/!\ Ne pas oublier the auth=true avec ajaxRequest

Retourne:
```json
[{
  id: int
  contenance: "string",
  nom: "string",
  pression: "string"
},
...]
```

### DELETE /plongee/equipement?id=int
Delete the equipement with the given id

### PUT /plongee/equipement?id=int
Update the equipement with the given id

```json
{
  "nom": "string",
  "contenance": "string",
  "pression": "string"
}
```
