-- Fondation -- 
CREATE TABLE Poles (
  Id_Poles INTEGER PRIMARY KEY AUTO_INCREMENT, 
  Intitule_Poles VARCHAR(12) NOT NULL,
  Description_Poles VARCHAR(64) DEFAULT NULL
);
CREATE TABLE Etablissements (
  Id_Etablissements INTEGER PRIMARY KEY AUTO_INCREMENT, 
  Intitule_Etablissements VARCHAR(64) NOT NULL,
  Adresse_Etablissements VARCHAR(256) NOT NULL,
  Ville_Etablissements VARCHAR(64) NOT NULL,
  CodePostal_Etablissements INTEGER NOT NULL,
  Description_Etablissements TEXT,

  Cle_Poles INTEGER DEFAULT NULL,

  FOREIGN KEY (Cle_Poles) REFERENCES Poles(Id_Poles)
);
CREATE TABLE Services (
  Id_Services INTEGER PRIMARY KEY AUTO_INCREMENT,
  Intitule_Services VARCHAR(64) NOT NULL,
  Description_Services TEXT
);
CREATE TABLE Appartenir_a (
  Cle_Etablissements INTEGER NOT NULL,
  Cle_Services INTEGER NOT NULL,

  FOREIGN KEY (Cle_Etablissements) REFERENCES Etablissements(Id_Etablissements),
  FOREIGN KEY (Cle_Services) REFERENCES Services(Id_Services),

  PRIMARY KEY (Cle_Etablissements, Cle_Services)
);
CREATE TABLE Postes (
  Id_Postes INTEGER PRIMARY KEY AUTO_INCREMENT,
  Intitule_Postes VARCHAR(64) NOT NULL,
  IntituleFeminin_Postes VARCHAR(64) NOT NULL
);

-- Utilisateurs --
CREATE TABLE Roles (
  Id_Roles INTEGER PRIMARY KEY AUTO_INCREMENT,
  Intitule_Roles VARCHAR(32) NOT NULL
);
CREATE TABLE Utilisateurs (
  Id_Utilisateurs INTEGER PRIMARY KEY AUTO_INCREMENT,
  Identifiant_Utilisateurs VARCHAR(64) NOT NULL,
  Nom_Utilisateurs VARCHAR(64) NOT NULL,
  Prenom_Utilisateurs VARCHAR(64) NOT NULL,
  Email_Utilisateurs VARCHAR(64) NOT NULL, 
  MotDePasse_Utilisateurs VARCHAR(256) NOT NULL,
  MotDePasseTemp_Utilisateurs BOOLEAN DEFAULT 1,

  Cle_Roles INTEGER NOT NULL,
  Cle_Etablissements INTEGER NOT NULL,

  FOREIGN KEY (Cle_Roles) REFERENCES Roles(Id_Roles),
  FOREIGN KEY (Cle_Etablissements) REFERENCES Etablissements(Id_Etablissements)
);

-- Logs --
CREATE TABLE Types_d_actions (
  Id_Types_d_actions INTEGER PRIMARY KEY AUTO_INCREMENT,
  Intitule_Types_d_actions VARCHAR(32) NOT NULL
);
CREATE TABLE Actions (
  Id_Actions INTEGER PRIMARY KEY AUTO_INCREMENT,
  Description_Actions TEXT DEFAULT NULL,
  Instant_Actions TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  Cle_Utilisateurs INTEGER NOT NULL,
  Cle_Types_d_actions INTEGER NOT NULL,

  FOREIGN KEY (Cle_Utilisateurs) REFERENCES Utilisateurs(Id_Utilisateurs),
  FOREIGN KEY (Cle_Types_d_actions) REFERENCES Types_d_actions(Id_Types_d_actions)
);

-- Candidats --
CREATE TABLE Candidats (
  Id_Candidats INTEGER PRIMARY KEY AUTO_INCREMENT,
  Nom_Candidats VARCHAR(64) NOT NULL,
  Prenom_Candidats VARCHAR(64) NOT NULL,
  Email_Candidats VARCHAR(64) NOT NULL,
  Telephone_Candidats VARCHAR(14) NOT NULL,
  Adresse_Candidats VARCHAR(256) NOT NULL,
  Ville_Candidats VARCHAR(64) NOT NULL,
  Displonibilte_Candidats DATE NOT NULL,
  VisiteMedicale_Candidats DATE DEFAULT NULL, 
  Description_Candidats TEXT DEFAULT NULL,
  Delete_Candidats BOOLEAN DEFAULT FALSE,
  A_Candidats BOOLEAN DEFAULT FALSE, 
  B_Candidats BOOLEAN DEFAULT FALSE, 
  C_Candidats BOOLEAN DEFAULT FALSE
);
CREATE TABLE Documents (
  Id INTEGER PRIMARY KEY AUTO_INCREMENT,
  Intitule VARCHAR(64) NOT NULL,
  Adresse VARCHAR(256) NOT NULL,

  Cle_Candidats INTEGER NOT NULL,

  FOREIGN KEY (Cle_Candidats) REFERENCES Candidats(Id_Candidats)
);

-- Qualifications --
CREATE TABLE Qualifications (
  Id_Qualifications INTEGER PRIMARY KEY AUTO_INCREMENT,
  Intitule_Qualifications VARCHAR(64) NOT NULL,
  PersonelMedical_Qualifications BOOLEAN DEFAULT FALSE, 
  Abreviation_Qualifications VARCHAR(12) NOT NULL
);
CREATE TABLE Obtenir (
  Cle_Candidats INTEGER NOT NULL,
  Cle_Qualifications INTEGER NOT NULL,

  Annee_Obtenir INTEGER NOT NULL, 

  FOREIGN KEY (Cle_Candidats) REFERENCES Candidats(Id_Candidats),
  FOREIGN KEY (Cle_Qualifications) REFERENCES Qualifications(Id_Qualifications),

  PRIMARY KEY (Cle_Candidats, Cle_Qualifications)
);

-- Aides --
CREATE TABLE Aides (
  Id_Aides INTEGER PRIMARY KEY AUTO_INCREMENT,
  Intitule_Aides VARCHAR(64) NOT NULL,
  Description_Aides TEXT DEFAULT NULL
);
CREATE TABLE Avoir_droit_a (
  Cle_Candidats INTEGER NOT NULL,
  Cle_Aides INTEGER NOT NULL,

  FOREIGN KEY (Cle_Candidats) REFERENCES Candidats(Id_Candidats),
  FOREIGN KEY (Cle_Aides) REFERENCES Aides(Id_Aides),

  PRIMARY KEY (Cle_Candidats, Cle_Aides)
);

-- Contrats --
CREATE TABLE Types_de_contrats (
  Id_Types_de_contrats INTEGER PRIMARY KEY AUTO_INCREMENT,
  Intitule_Types_de_contrats VARCHAR(64) NOT NULL,
  Description_Types_de_contrats TEXT DEFAULT NULL
);
CREATE TABLE Contrats (
  Id_ INTEGER PRIMARY KEY AUTO_INCREMENT,
  DateDebut_ DATE NOT NULL, 
  DateFin_ DATE DEFAULT NULL,
  DateProposition_ DATE NOT NULL DEFAULT CURRENT_TIMESTAMP, 
  DateSignature_ DATE DEFAULT NULL, 
  DateDemission_ DATE DEFAULT NULL,
  Salaires_ INTEGER, 
  TravailNuit_ BOOLEAN DEFAULT FALSE,
  TravailWeekEnd_ BOOLEAN DEFAULT FALSE,

  Cle_Candidats INTEGER NOT NULL,
  Cle_Types_de_contrats INTEGER NOT NULL,
  Cle_Postes INTEGER NOT NULL,
  Cle_Services INTEGER NOT NULL,
  Cle_Etablissements INTEGER NOT NULL,

  FOREIGN KEY (Cle_Candidats) REFERENCES Candidats(Id_Candidats),
  FOREIGN KEY (Cle_Types_de_contrats) REFERENCES Types_de_contrats(Id_Types_de_contrats),
  FOREIGN KEY (Cle_Postes) REFERENCES Postes(Id_Postes),
  FOREIGN KEY (Cle_Services) REFERENCES Services(Id_Services),
  FOREIGN KEY (Cle_Etablissements) REFERENCES Etablissements(Id_Etablissements)
);

-- Besoins --
CREATE TABLE Besoins (
  Id_Besoins INTEGER PRIMARY KEY AUTO_INCREMENT,
  DateDebut_Besoins DATE NOT NULL,
  DateFin_Besoins DATE DEFAULT NULL,
  HeureDebut_Besoins TIME DEFAULT NULL,
  HeureFin_Besoins TIME DEFAULT NULL,
  Description_Besoins TEXT DEFAULT NULL,

  Cle_Postes INTEGER NOT NULL,
  Cle_Types_de_contrats INTEGER NOT NULL,

  FOREIGN KEY (Cle_Postes) REFERENCES Postes(Id_Postes),
  FOREIGN KEY (Cle_Types_de_contrats) REFERENCES Types_de_contrats(Id_Types_de_contrats)
);
CREATE TABLE Necessiter (
  Cle_Besoins INTEGER NOT NULL,
  Cle_Qualifications INTEGER NOT NULL,

  FOREIGN KEY (Cle_Besoins) REFERENCES Besoins(Id_Besoins),
  FOREIGN KEY (Cle_Qualifications) REFERENCES Qualifications(Id_Qualifications),

  PRIMARY KEY (Cle_Besoins, Cle_Qualifications)
);

-- Candidatures 
CREATE TABLE Sources (
  Id_Sources INTEGER PRIMARY KEY AUTO_INCREMENT,
  Intitule_Sources VARCHAR(64) NOT NULL
);
CREATE TABLE Candidatures (
  Id_Candidatures INTEGER PRIMARY KEY AUTO_INCREMENT,
  Statut_Candidatures VARCHAR(24),
  Instant_Candidatures TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

  Cle_Candidats INTEGER NOT NULL,
  Cle_Postes INTEGER NOT NULL,
  Cle_Types_de_contrats INTEGER NOT NULL,
  Cle_Sources INTEGER NOT NULL,
  Cle_Besoins INTEGER,
  Cle_Etablissements INTEGER,
  Cle_Services INTEGER,

  FOREIGN KEY (Cle_Candidats) REFERENCES Candidats(Id_Candidats),
  FOREIGN KEY (Cle_Postes) REFERENCES Postes(Id_Postes),
  FOREIGN KEY (Cle_Types_de_contrats) REFERENCES Types_de_contrats(Id_Types_de_contrats),
  FOREIGN KEY (Cle_Sources) REFERENCES Sources(Id_Sources),
  FOREIGN KEY (Cle_Besoins) REFERENCES Besoins(Id_Besoins),
  FOREIGN KEY (Cle_Etablissements) REFERENCES Etablissements(Id_Etablissements),
  FOREIGN KEY (Cle_Services) REFERENCES Services(Id_Services)
);

-- Rendez-vous --
CREATE TABLE Instants (
  Id_Instants INTEGER PRIMARY KEY AUTO_INCREMENT,
  Date_Instants TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE Avoir_rendez_vous_avec (
  Cle_Utilisateurs INTEGER NOT NULL,
  Cle_Candidats INTEGER NOT NULL,
  Cle_Etablissements INTEGER NOT NULL,
  Cle_Instants INTEGER NOT NULL,

  FOREIGN KEY (Cle_Utilisateurs) REFERENCES Utilisateurs(Id_Utilisateurs),
  FOREIGN KEY (Cle_Candidats) REFERENCES Candidats(Id_Candidats),
  FOREIGN KEY (Cle_Etablissements) REFERENCES Etablissements(Id_Etablissements),
  FOREIGN KEY (Cle_Instants) REFERENCES Instants(Id_Instants)
);