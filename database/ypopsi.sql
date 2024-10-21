-- Fondation -- 
CREATE TABLE Poles (
  Id_Poles INTEGER PRIMARY KEY AUTO_INCREMENT, 
  Titled_Poles VARCHAR(12) NOT NULL,
  Description_Poles VARCHAR(64) DEFAULT NULL
);
CREATE TABLE Establishments (
  Id_Establishments INTEGER PRIMARY KEY AUTO_INCREMENT, 
  Titled_Establishments VARCHAR(64) NOT NULL,
  Address_Establishments VARCHAR(256) NOT NULL,
  City_Establishments VARCHAR(64) NOT NULL,
  PostCode_Establishments INTEGER NOT NULL,
  Description_Establishments TEXT,

  Key_Poles INTEGER DEFAULT NULL,

  FOREIGN KEY (Key_Poles) REFERENCES Poles(Id_Poles)
);
CREATE TABLE Services (
  Id_Services INTEGER PRIMARY KEY AUTO_INCREMENT,
  Titled_Services VARCHAR(64) NOT NULL,
  Description_Services TEXT
);
CREATE TABLE Belong_to (
  Key_Establishments INTEGER NOT NULL,
  Key_Services INTEGER NOT NULL,

  FOREIGN KEY (Key_Establishments) REFERENCES Establishments(Id_Establishments),
  FOREIGN KEY (Key_Services) REFERENCES Services(Id_Services),

  PRIMARY KEY (Key_Establishments, Key_Services)
);
CREATE TABLE Jobs (
  Id_Jobs INTEGER PRIMARY KEY AUTO_INCREMENT,
  Titled_Jobs VARCHAR(64) NOT NULL,
  TitledFeminin_Jobs VARCHAR(64) NOT NULL
);

-- Users --
CREATE TABLE Roles (
  Id_Roles INTEGER PRIMARY KEY AUTO_INCREMENT,
  Titled_Roles VARCHAR(32) NOT NULL
);
CREATE TABLE Users (
  Id_Users INTEGER PRIMARY KEY AUTO_INCREMENT,
  Identifier_Users VARCHAR(64) NOT NULL,
  Name_Users VARCHAR(64) NOT NULL,
  Firstname_Users VARCHAR(64) NOT NULL,
  Email_Users VARCHAR(64) NOT NULL, 
  Password_Users VARCHAR(256) NOT NULL,
  PasswordTemp_Users BOOLEAN DEFAULT 1,

  Key_Roles INTEGER NOT NULL,
  Key_Establishments INTEGER NOT NULL,

  FOREIGN KEY (Key_Roles) REFERENCES Roles(Id_Roles),
  FOREIGN KEY (Key_Establishments) REFERENCES Establishments(Id_Establishments)
);

-- Logs --
CREATE TABLE Types_of_actions (
  Id_Types_of_actions INTEGER PRIMARY KEY AUTO_INCREMENT,
  Titled_Types_of_actions VARCHAR(32) NOT NULL
);
CREATE TABLE Actions (
  Id_Actions INTEGER PRIMARY KEY AUTO_INCREMENT,
  Description_Actions TEXT DEFAULT NULL,
  Moment_Actions TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  Key_Users INTEGER NOT NULL,
  Key_Types_of_actions INTEGER NOT NULL,

  FOREIGN KEY (Key_Users) REFERENCES Users(Id_Users),
  FOREIGN KEY (Key_Types_of_actions) REFERENCES Types_of_actions(Id_Types_of_actions)
);

-- Candidates --
CREATE TABLE Candidates (
  Id_Candidates INTEGER PRIMARY KEY AUTO_INCREMENT,
  Name_Candidates VARCHAR(64) NOT NULL,
  Firstname_Candidates VARCHAR(64) NOT NULL,
  Email_Candidates VARCHAR(64) NOT NULL,
  Phone_Candidates VARCHAR(14) NOT NULL,
  Address_Candidates VARCHAR(256) NOT NULL,
  City_Candidates VARCHAR(64) NOT NULL,
  PostCode_Candidates VARCHAR(5) NOT NULL, 
  Availability_Candidates DATE NOT NULL,
  MedicalVisit_Candidates DATE DEFAULT NULL, 
  Description_Candidates TEXT DEFAULT NULL,
  Delete_Candidates BOOLEAN DEFAULT FALSE,
  A_Candidates BOOLEAN DEFAULT FALSE, 
  B_Candidates BOOLEAN DEFAULT FALSE, 
  C_Candidates BOOLEAN DEFAULT FALSE
);
CREATE TABLE Documents (
  Id_Documents INTEGER PRIMARY KEY AUTO_INCREMENT,
  Titled_Documents VARCHAR(64) NOT NULL,
  Address_Documents VARCHAR(256) NOT NULL,

  Key_Candidates INTEGER NOT NULL,

  FOREIGN KEY (Key_Candidates) REFERENCES Candidates(Id_Candidates)
);

-- Qualifications --
CREATE TABLE Qualifications (
  Id_Qualifications INTEGER PRIMARY KEY AUTO_INCREMENT,
  Titled_Qualifications VARCHAR(64) NOT NULL,
  MedicalStaff_Qualifications BOOLEAN DEFAULT FALSE, 
  Abreviation_Qualifications VARCHAR(12) NOT NULL
);
CREATE TABLE Get (
  Key_Candidates INTEGER NOT NULL,
  Key_Qualifications INTEGER NOT NULL,

  Annee_Get INTEGER NOT NULL, 

  FOREIGN KEY (Key_Candidates) REFERENCES Candidates(Id_Candidates),
  FOREIGN KEY (Key_Qualifications) REFERENCES Qualifications(Id_Qualifications),

  PRIMARY KEY (Key_Candidates, Key_Qualifications)
);

-- Helps --
CREATE TABLE Helps (
  Id_Helps INTEGER PRIMARY KEY AUTO_INCREMENT,
  Titled_Helps VARCHAR(64) NOT NULL,
  Description_Helps TEXT DEFAULT NULL
);
CREATE TABLE Have_the_right_to (
  Key_Candidates INTEGER NOT NULL,
  Key_Helps INTEGER NOT NULL,

  FOREIGN KEY (Key_Candidates) REFERENCES Candidates(Id_Candidates),
  FOREIGN KEY (Key_Helps) REFERENCES Helps(Id_Helps),

  PRIMARY KEY (Key_Candidates, Key_Helps)
);

-- Contracts --
CREATE TABLE Types_of_contracts (
  Id_Types_of_contracts INTEGER PRIMARY KEY AUTO_INCREMENT,
  Titled_Types_of_contracts VARCHAR(64) NOT NULL,
  Description_Types_of_contracts TEXT DEFAULT NULL
);
CREATE TABLE Contracts (
  Id_Contracts INTEGER PRIMARY KEY AUTO_INCREMENT,
  StartDate_Contracts DATE NOT NULL, 
  EndDate_Contracts DATE DEFAULT NULL,
  PropositionDate_Contracts DATE NOT NULL DEFAULT CURRENT_TIMESTAMP, 
  SignatureDate_Contracts DATE DEFAULT NULL, 
  ResignationDate_Contracts DATE DEFAULT NULL,
  Salary_Contracts INTEGER, 
  NightWork_Contracts BOOLEAN DEFAULT FALSE,
  WeekEndWork_Contracts BOOLEAN DEFAULT FALSE,

  Key_Candidates INTEGER NOT NULL,
  Key_Types_of_contracts INTEGER NOT NULL,
  Key_Jobs INTEGER NOT NULL,
  Key_Services INTEGER NOT NULL,
  Key_Establishments INTEGER NOT NULL,

  FOREIGN KEY (Key_Candidates) REFERENCES Candidates(Id_Candidates),
  FOREIGN KEY (Key_Types_of_contracts) REFERENCES Types_of_contracts(Id_Types_of_contracts),
  FOREIGN KEY (Key_Jobs) REFERENCES Jobs(Id_Jobs),
  FOREIGN KEY (Key_Services) REFERENCES Services(Id_Services),
  FOREIGN KEY (Key_Establishments) REFERENCES Establishments(Id_Establishments)
);

-- Needs --
CREATE TABLE Needs (
  Id_Needs INTEGER PRIMARY KEY AUTO_INCREMENT,
  StartDate_Needs DATE NOT NULL,
  EndDate_Needs DATE DEFAULT NULL,
  StartHour_Needs TIME DEFAULT NULL,
  EndHour_Needs TIME DEFAULT NULL,
  Description_Needs TEXT DEFAULT NULL,

  Key_Jobs INTEGER NOT NULL,
  Key_Types_of_contracts INTEGER NOT NULL,

  FOREIGN KEY (Key_Jobs) REFERENCES Jobs(Id_Jobs),
  FOREIGN KEY (Key_Types_of_contracts) REFERENCES Types_of_contracts(Id_Types_of_contracts)
);
CREATE TABLE Necessiter (
  Key_Needs INTEGER NOT NULL,
  Key_Qualifications INTEGER NOT NULL,

  FOREIGN KEY (Key_Needs) REFERENCES Needs(Id_Needs),
  FOREIGN KEY (Key_Qualifications) REFERENCES Qualifications(Id_Qualifications),

  PRIMARY KEY (Key_Needs, Key_Qualifications)
);

-- applications 
CREATE TABLE Sources (
  Id_Sources INTEGER PRIMARY KEY AUTO_INCREMENT,
  Titled_Sources VARCHAR(64) NOT NULL
);
CREATE TABLE Applications (
  Id_applications INTEGER PRIMARY KEY AUTO_INCREMENT,
  Status_applications VARCHAR(24),
  Moment_applications TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

  Key_Candidates INTEGER NOT NULL,
  Key_Jobs INTEGER NOT NULL,
  Key_Types_of_contracts INTEGER NOT NULL,
  Key_Sources INTEGER NOT NULL,
  Key_Needs INTEGER,
  Key_Establishments INTEGER,
  Key_Services INTEGER,

  FOREIGN KEY (Key_Candidates) REFERENCES Candidates(Id_Candidates),
  FOREIGN KEY (Key_Jobs) REFERENCES Jobs(Id_Jobs),
  FOREIGN KEY (Key_Types_of_contracts) REFERENCES Types_of_contracts(Id_Types_of_contracts),
  FOREIGN KEY (Key_Sources) REFERENCES Sources(Id_Sources),
  FOREIGN KEY (Key_Needs) REFERENCES Needs(Id_Needs),
  FOREIGN KEY (Key_Establishments) REFERENCES Establishments(Id_Establishments),
  FOREIGN KEY (Key_Services) REFERENCES Services(Id_Services)
);

-- Rendez-vous --
CREATE TABLE Moments (
  Id_Moments INTEGER PRIMARY KEY AUTO_INCREMENT,
  Date_Moments TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE Have_a_meet_with (
  Key_Users INTEGER NOT NULL,
  Key_Candidates INTEGER NOT NULL,
  Key_Establishments INTEGER NOT NULL,
  Key_Moments INTEGER NOT NULL,

  FOREIGN KEY (Key_Users) REFERENCES Users(Id_Users),
  FOREIGN KEY (Key_Candidates) REFERENCES Candidates(Id_Candidates),
  FOREIGN KEY (Key_Establishments) REFERENCES Establishments(Id_Establishments),
  FOREIGN KEY (Key_Moments) REFERENCES Moments(Id_Moments)
);