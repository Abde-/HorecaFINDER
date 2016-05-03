/*  
 *  Abdeselam El-Haman  et  Cédric Simar
 *  INFO-H-303 : Bases de données - Projet Horeca (partie 2)
 * 
 *  Script SQL DDL de création de la base de donnée et de ses
 *  différentes tables déduit de notre modèle relationel
*/


CREATE TABLE Etablissement (
    Nom                         VARCHAR(75) NOT NULL,
    Adresse_Rue                 VARCHAR(50) NOT NULL,
    Adresse_Numero              VARCHAR(50) NOT NULL,
    Adresse_CodePostal          VARCHAR(12) NOT NULL,  -- codes postaux au Canada avec des lettres => VARCHAR
    Adresse_Localite            VARCHAR(50) NOT NULL,
    Coordonnees_Longitude       VARCHAR(25),
    Coordonnees_Latitude        VARCHAR(25),
    Telephone                   VARCHAR(25) NOT NULL,
    SiteWeb                     VARCHAR(75),
    Createur                    VARCHAR(30) NOT NULL,
    DateCreation                DATE        NOT NULL,               

    PRIMARY KEY (Nom),
    FOREIGN KEY (Createur) REFERENCES Administrateur(UID),
    CONSTRAINT check_type CHECK (Type IN ('Hotel', 'Restaurant', 'Bar'))
);


CREATE TABLE Hotel (
    Nom                         VARCHAR(75) NOT NULL,
    NombreEtoiles               SMALLINT(1) NOT NULL,
    NombreChambres              SMALLINT    NOT NULL,
    PrixNuit                    SMALLINT    NOT NULL,

    PRIMARY KEY (Nom),
    FOREIGN KEY (Nom) REFERENCES Etablissement(Nom),
    CONSTRAINT check_etoiles CHECK (NombreEtoiles >= 0 AND NombreEtoiles <= 5),
    CONSTRAINT check_chambres CHECK (NombreChambres >= 0),
    CONSTRAINT check_etoiles CHECK (PrixNuit >= 0)
);


CREATE TABLE Restaurant (
    Nom                         VARCHAR(75) NOT NULL,
    FourchettePrixPlat          SMALLINT    NOT NULL,
    PlacesMax                   SMALLINT    NOT NULL,    -- enlever les NOT NULL ??
    Emporter                    BOOLEAN     NOT NULL,
    Livraison                   BOOLEAN     NOT NULL,

    PRIMARY KEY (Nom),
    FOREIGN KEY (Nom) REFERENCES Etablissement(Nom),
    CONSTRAINT check_fourchette CHECK (FourchettePrixPlat >= 0),
    CONSTRAINT check_places CHECK (PlacesMax >= 0)
);


CREATE TABLE Bar (
    Nom                         VARCHAR(75) NOT NULL,
    Fumeur                      BOOLEAN     NOT NULL,
    Snack                       BOOLEAN     NOT NULL,

    PRIMARY KEY (Nom),
    FOREIGN KEY (Nom) REFERENCES Etablissement(Nom)
);


CREATE TABLE Fermeture (
    Nom                         VARCHAR(75) NOT NULL,
    Jour                        SMALLINT(1) NOT NULL,
    Heure                       VARCHAR(2)  NOT NULL,

    PRIMARY KEY (Nom, Jour, Heure),
    FOREIGN KEY (Nom) REFERENCES Restaurant(Nom),
    CONSTRAINT check_jour CHECK (Jour >= 0 AND Jour <= 6),
    CONSTRAINT check_heure CHECK (Heure IN ('am', 'pm'))             
);


CREATE TABLE Utilisateur (
    UID                         VARCHAR(30) NOT NULL,
    Email                       VARCHAR(50) NOT NULL,
    MotDePasse                  VARCHAR(50) NOT NULL,
    DateEnregistrement          DATE        NOT NULL,

    PRIMARY KEY (UID),
    KEY (Email)
);


CREATE TABLE Administrateur (
    UID                         VARCHAR(30) NOT NULL,

    PRIMARY KEY (UID),
    FOREIGN KEY (UID) REFERENCES Utilisateur(UID)
);


CREATE TABLE Commentaire (
    Score                       SMALLINT(2) NOT NULL,
    Texte                       VARCHAR(1000) NOT NULL,
    DateCommentaire             DATE        NOT NULL,
    
    UID                         VARCHAR(30) NOT NULL,
    Nom                         VARCHAR(75) NOT NULL,
    
    PRIMARY KEY (UID, Nom, DateCommentaire),
    FOREIGN KEY (UID) REFERENCES Utilisateur(UID),
    FOREIGN KEY (Nom) REFERENCES Etablissement(Nom),
    CONSTRAINT check_score CHECK (Score >= 0 AND Score <= 10),
    CONSTRAINT check_texte CHECK (char_length(Texte) >= 100)  -- un commentaire de moins de 100 caractère est bidon
    -- CONSTRAINT check_date  CHECK (DateCommentaire >= Etablissement(Nom).DateCreation
);


CREATE TABLE Tag (
    Label                       VARCHAR(15) NOT NULL,
    
    PRIMARY KEY (Label)
);


CREATE TABLE Labelise (
    UID                         VARCHAR(30) NOT NULL,
    Nom                         VARCHAR(75) NOT NULL,
    Label                       VARCHAR(15) NOT NULL,
    
    PRIMARY KEY (UID, Nom, Label),
    FOREIGN KEY (UID) REFERENCES Utilisateur(UID),
    FOREIGN KEY (Nom) REFERENCES Etablissement(Nom),
    FOREIGN KEY (Label) REFERENCES Tag(Label)
);














    
