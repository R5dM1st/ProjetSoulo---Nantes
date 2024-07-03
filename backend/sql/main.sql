DROP TABLE IF EXISTS "user";
CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    user_mail VARCHAR(150) UNIQUE,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    hash_password VARCHAR(100),
    session_id VARCHAR(100)
);

-- Table Settings
DROP TABLE IF EXISTS plongee_settings;
CREATE TABLE plongee_settings (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(50),
    profondeur FLOAT,
    duree INT,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES "user"(id)
);

DROP TABLE IF EXISTS equipement;
CREATE TABLE equipement (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(50),
    contenance INT,
    pression INT,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES "user"(id)
);


-- Table Plongée
DROP TABLE IF EXISTS plongee_profile;
CREATE TABLE plongee_profile (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(50),
    vitesse_desc FLOAT,
    vitesse_asc FLOAT,
    respiration FLOAT,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES "user"(id)
);


-- Table Plongée
DROP TABLE IF EXISTS plongee;
CREATE TABLE plongee (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(50),
    date DATE,
    private BOOLEAN,
    user_id INT,
    plongee_profile_id INT,
    plongee_settings_id INT,
    equipement_id INT,
    FOREIGN KEY (user_id) REFERENCES "user"(id),
    FOREIGN KEY (plongee_profile_id) REFERENCES plongee_profile(id),
    FOREIGN KEY (plongee_settings_id) REFERENCES plongee_settings(id),
    FOREIGN KEY (equipement_id) REFERENCES equipement(id)
);



-- DEFAULT equipement
INSERT INTO equipement (nom, contenance, pression) VALUES ('Bouteille par defaut', 15, 200);

-- DEFAULT PLONGEE PROFILE
INSERT INTO plongee_profile (nom, vitesse_desc, vitesse_asc, respiration) VALUES ('Profil par defaut', 20, 10, 20);


-- Give permissions to all tables
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO groupe3;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO groupe3;
GRANT ALL PRIVILEGES ON ALL FUNCTIONS IN SCHEMA public TO groupe3;
