-- Fondation -- 
CREATE TABLE Poles (
    Id_Poles INTEGER PRIMARY KEY AUTO_INCREMENT, 
    Intitule_Poles varchar(64) NOT NULL,
    Description_Poles text
);
CREATE TABLE Etablissements (
    Id_Etablissements INTEGER PRIMARY KEY AUTO_INCREMENT, 
    Intitule_Etablissements varchar(64) NOT NULL,
    Adresse_Etablissements varchar(256) NOT NULL,
    Ville_Etablissements varchar(64) NOT NULL,
    CodePostal_Etablissements INTEGER NOT NULL,
    Description_Etablissements text,

    Cle_Poles INTEGER NOT NULL,

    FOREIGN KEY (Cle_Poles) REFERENCES Poles(Id_Poles)
);
CREATE TABLE Services (
    Id_Services INTEGER PRIMARY KEY AUTO_INCREMENT,
    Intitule_Services VARCHAR(64) NOT NULL,
    Description_Services text
);
CREATE TABLE Appartenir_a (
    Cle_Etablissements INTEGER NOT NULL,
    Cle_Services INTEGER NOT NULL,

    FOREIGN KEY (Cle_Etablissements) REFERENCES Etablissements(Id_Etablissements),
    FOREIGN KEY (Cle_Services) REFERENCES Services(Id_Services),

    PRIMARY KEY (Cle_Etablissements, Cle_Services)
);

-- Utilisateurs --
CREATE TABLE Roles (
    Id_Roles INTEGER PRIMARY KEY,
    Intitule_Roles VARCHAR(32) NOT NULL
);
CREATE TABLE Utilisateurs (
    Id_Utilisateurs INTEGER PRIMARY KEY,
    Identifiant_Utilisateurs VARCHAR(64) NOT NULL,
    Nom_Utilisateurs VARCHAR(64) NOT NULL,
    Prenom_Utilisateurs VARCHAR(64) NOT NULL,
    MotDePasse_Utilisateurs VARCHAR(256) NOT NULL,
    MotDePasseTemp_Utilisateurs BOOLEAN DEFAULT 1,

    Cle_Roles INTEGER NOT NULL,
    Cle_Etablissements INTEGER NOT NULL,

    FOREIGN KEY (Cle_Roles) REFERENCES Roles(Id_Roles),
    FOREIGN KEY (Cle_Etablissements) REFERENCES Etablissements(Id_Etablissements)
);

-- Logs --
CREATE TABLE Types_d_actions (
    Id_Types_d_actions INTEGER PRIMARY KEY,
    Intitule_Types_d_actions VARCHAR(32) NOT NULL
);
CREATE TABLE Actions (
    Id_Actions INTEGER PRIMARY KEY,
    Description_Actions text DEFAULT NULL,
    Instant_Actions TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    Cle_Utilisateurs INTEGER NOT NULL,
    Cle_Types_d_actions INTEGER NOT NULL,

    FOREIGn KEY (Cle_Utilisateurs) REFERENCES Utilisateurs(Id_Utilisateurs),
    FOREIGn KEY (Cle_Types_d_actions) REFERENCES Types_d_actions(Id_Types_d_actions)
);