-- SUPRESSION DES CANDIDATS --
DROP TABLE Meetings;
DROP TABLE Applications;
DROP TABLE Contracts;

DROP TABLE Documents;
DROP TABLE Have_the_right_to;
DROP TABLE Get_qualifications;
DROP TABLE Candidates;

-- GEBERATION DES NOUVELLES TABLES --
CREATE TABLE Candidates (
    Id INTEGER PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(64) NOT NULL,
    Firstname VARCHAR(64) NOT NULL,
    Gender BOOLEAN NOT NULL,
    Email VARCHAR(64) DEFAULT NULL,
    Phone VARCHAR(14) DEFAULT NULL,
    Address VARCHAR(256) DEFAULT NULL,
    City VARCHAR(64) DEFAULT NULL,
    PostCode VARCHAR(5) DEFAULT NULL, 
    Availability DATE DEFAULT NULL,
    MedicalVisit DATE DEFAULT NULL, 
    Rating INTEGER DEFAULT NULL,
    Description TEXT DEFAULT NULL,
    Is_delete BOOLEAN DEFAULT FALSE,
    A BOOLEAN DEFAULT FALSE, 
    B BOOLEAN DEFAULT FALSE, 
    C BOOLEAN DEFAULT FALSE,

    CHECK (
        (Address IS NOT NULL AND City IS NOT NULL AND PostCode IS NOT NULL) OR
        (Address IS NULL AND City IS NULL AND PostCode IS NULL)
    )
);
CREATE TABLE Have_the_right_to (
    Key_Candidates INTEGER NOT NULL,
    Key_Helps INTEGER NOT NULL,
    Key_Employee INTEGER DEFAULT NULL,

    FOREIGN KEY (Key_Candidates) REFERENCES Candidates(Id),
    FOREIGN KEY (Key_Helps) REFERENCES Helps(Id),
    FOREIGN KEY (Key_Employee) REFERENCES Candidates(Id),

    PRIMARY KEY (Key_Candidates, Key_Helps)
);
CREATE TABLE Get_qualifications (
    Key_Candidates INTEGER NOT NULL,
    Key_Qualifications INTEGER NOT NULL,

    Date TIMESTAMP NOT NULL, 

    FOREIGN KEY (Key_Candidates) REFERENCES Candidates(Id),
    FOREIGN KEY (Key_Qualifications) REFERENCES Qualifications(Id),

    PRIMARY KEY (Key_Candidates, Key_Qualifications)
);
CREATE TABLE Documents (
    Id INTEGER PRIMARY KEY AUTO_INCREMENT,
    Titled VARCHAR(64) NOT NULL,
    Address VARCHAR(256) NOT NULL,

    Key_Candidates INTEGER NOT NULL,

    FOREIGN KEY (Key_Candidates) REFERENCES Candidates(Id)
);

CREATE TABLE Contracts (
    Id INTEGER PRIMARY KEY AUTO_INCREMENT,
    StartDate DATE NOT NULL, 
    EndDate DATE DEFAULT NULL,
    PropositionDate DATE NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    SignatureDate DATE DEFAULT NULL, 
    ResignationDate DATE DEFAULT NULL,
    IsRefused BOOLEAN DEFAULT FALSE, 
    Salary INTEGER DEFAULT NULL, 
    HourlyRate INTEGER DEFAULT NULL, 
    NightWork BOOLEAN DEFAULT FALSE,
    WeekEndWork BOOLEAN DEFAULT FALSE,

    Key_Candidates INTEGER NOT NULL,
    Key_Jobs INTEGER NOT NULL,
    Key_Services INTEGER NOT NULL,
    Key_Establishments INTEGER NOT NULL,
    Key_Types_of_contracts INTEGER NOT NULL,

    FOREIGN KEY (Key_Candidates) REFERENCES Candidates(Id),
    FOREIGN KEY (Key_Types_of_contracts) REFERENCES Types_of_contracts(Id),
    FOREIGN KEY (Key_Jobs) REFERENCES Jobs(Id),
    FOREIGN KEY (Key_Services) REFERENCES Services(Id),
    FOREIGN KEY (Key_Establishments) REFERENCES Establishments(Id),

    CHECK(PropositionDate <= StartDate AND StartDate <= EndDate),
    CHECK(PropositionDate <= SignatureDate AND SignatureDate <= EndDate),
    CHECK(ResignationDate <= EndDate)
);
CREATE TABLE Applications (
    Id INTEGER PRIMARY KEY AUTO_INCREMENT,
    IsAccepted BOOLEAN DEFAULT FALSE,
    IsRefused BOOLEAN DEFAULT FALSE,
    Moment TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    Key_Candidates INTEGER NOT NULL,
    Key_Jobs INTEGER NOT NULL,
    Key_Types_of_contracts INTEGER DEFAULT NULL,
    Key_Sources INTEGER NOT NULL,
    Key_Needs INTEGER DEFAULT NULL,
    Key_Establishments INTEGER DEFAULT NULL,
    Key_Services INTEGER DEFAULT NULL,

    FOREIGN KEY (Key_Candidates) REFERENCES Candidates(Id),
    FOREIGN KEY (Key_Jobs) REFERENCES Jobs(Id),
    FOREIGN KEY (Key_Types_of_contracts) REFERENCES Types_of_contracts(Id),
    FOREIGN KEY (Key_Sources) REFERENCES Sources(Id),
    FOREIGN KEY (Key_Needs) REFERENCES Needs(Id),
    FOREIGN KEY (Key_Establishments) REFERENCES Establishments(Id),
    FOREIGN KEY (Key_Services) REFERENCES Services(Id),

    CHECK (
        (Key_Establishments IS NULL AND Key_Services IS NULL AND Key_Needs IS NULL) OR
        (Key_Establishments IS NOT NULL AND Key_Services IS NULL AND Key_Needs IS NULL) OR
        (Key_Establishments IS NULL AND Key_Services IS NOT NULL AND Key_Needs IS NULL) OR
        (Key_Establishments IS NOT NULL AND Key_Services IS NOT NULL AND Key_Needs IS NULL) OR
        (Key_Needs IS NOT NULL AND Key_Establishments IS NULL AND Key_Services IS NULL)
    )  
);
CREATE TABLE Meetings (
    Id INTEGER PRIMARY KEY AUTO_INCREMENT,
    Date TIMESTAMP NOT NULL,
    Description TEXT DEFAULT NULL, 

    Key_Users INTEGER NOT NULL,
    Key_Candidates INTEGER NOT NULL,
    Key_Establishments INTEGER NOT NULL,

    FOREIGN KEY (Key_Users) REFERENCES Users(Id),
    FOREIGN KEY (Key_Candidates) REFERENCES Candidates(Id),
    FOREIGN KEY (Key_Establishments) REFERENCES Establishments(Id)
);

-- AJOUT DES NOUVELLES DONNEES --
INSERT INTO Jobs (Titled, TitledFeminin) VALUES
    ("GESTIONNAIRE DE PAIE", "GESTIONNAIRE DE PAIE"),
    ("INFIRMIER COORDINATEUR", "INFIRMIERE COORDINATRICE")
;

INSERT INTO Qualifications (Titled, MedicalStaff, Abreviation) VALUES 
    ("Aide médico-psychologique D.E.", TRUE, "A.M.P."),
    ("Auxiliaire de vie social D.E.", FALSE, "A.V.S."),
    ("Diplôme d'Etat d'Ergothérapeute", TRUE, NULL),
    ("Mention Complétaire Aide à Domicile", FALSE, "M.C.A.D.")
;

INSERT INTO Types_of_contracts (Titled, Description) VALUES 
    ("vacation", "Mission réalisée par un vacataire")
;

INSERT INTO sources (Titled) VALUES 
    ("France Travail"),
    ("Job Dating"),
    ("Recommandée"),
    ("Salon Emploi Formation"),
    ("Spontanée")
;

INSERT INTO Services (Titled, Description) VALUES 
    ("USLD", "Unités de soins de longue durée"),
    ("SOINS", "Unités de soins réservées aux petites structures")
;

INSERT INTO Belong_to (Key_Services, Key_Establishments) VALUES
    (199, 4),
    (200, 11),
    (200, 13)
;