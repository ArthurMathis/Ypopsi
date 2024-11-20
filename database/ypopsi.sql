-- Fondation -- 
CREATE TABLE Poles (
  Id INTEGER PRIMARY KEY AUTO_INCREMENT, 
  Titled VARCHAR(12) NOT NULL,
  Description VARCHAR(64) DEFAULT NULL
);
CREATE TABLE Establishments (
  Id INTEGER PRIMARY KEY AUTO_INCREMENT, 
  Titled VARCHAR(64) NOT NULL,
  Address VARCHAR(256) NOT NULL,
  City VARCHAR(64) NOT NULL,
  PostCode INTEGER NOT NULL,
  Description TEXT,

  Key_Poles INTEGER DEFAULT NULL,

  FOREIGN KEY (Key_Poles) REFERENCES Poles(Id)
);
CREATE TABLE Services (
  Id INTEGER PRIMARY KEY AUTO_INCREMENT,
  Titled VARCHAR(64) NOT NULL,
  Description TEXT
);
CREATE TABLE Belong_to (
  Key_Establishments INTEGER NOT NULL,
  Key_Services INTEGER NOT NULL,

  FOREIGN KEY (Key_Establishments) REFERENCES Establishments(Id),
  FOREIGN KEY (Key_Services) REFERENCES Services(Id),

  PRIMARY KEY (Key_Establishments, Key_Services)
);
CREATE TABLE Jobs (
  Id INTEGER PRIMARY KEY AUTO_INCREMENT,
  Titled VARCHAR(64) NOT NULL,
  TitledFeminin VARCHAR(64) NOT NULL
);

-- Users --
CREATE TABLE Roles (
  Id INTEGER PRIMARY KEY AUTO_INCREMENT,
  Titled VARCHAR(32) NOT NULL
);
CREATE TABLE Users (
  Id INTEGER PRIMARY KEY AUTO_INCREMENT,
  Identifier VARCHAR(64) NOT NULL,
  Name VARCHAR(64) NOT NULL,
  Firstname VARCHAR(64) NOT NULL,
  Email VARCHAR(64) NOT NULL, 
  Password VARCHAR(256) NOT NULL,
  PasswordTemp BOOLEAN DEFAULT 1,

  Key_Roles INTEGER NOT NULL,
  Key_Establishments INTEGER NOT NULL,

  FOREIGN KEY (Key_Roles) REFERENCES Roles(Id),
  FOREIGN KEY (Key_Establishments) REFERENCES Establishments(Id)
);

-- Logs --
CREATE TABLE Types_of_actions (
  Id INTEGER PRIMARY KEY AUTO_INCREMENT,
  Titled VARCHAR(32) NOT NULL
);
CREATE TABLE Actions (
  Id INTEGER PRIMARY KEY AUTO_INCREMENT,
  Description TEXT DEFAULT NULL,
  Moment TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  Key_Users INTEGER NOT NULL,
  Key_Types_of_actions INTEGER NOT NULL,

  FOREIGN KEY (Key_Users) REFERENCES Users(Id),
  FOREIGN KEY (Key_Types_of_actions) REFERENCES Types_of_actions(Id)
);

-- Candidates --
CREATE TABLE Candidates (
  Id INTEGER PRIMARY KEY AUTO_INCREMENT,
  Name VARCHAR(64) NOT NULL,
  Firstname VARCHAR(64) NOT NULL,
  Gender BOOLEAN NOT NULL,
  Email VARCHAR(64) DEFAULT NULL UNIQUE,
  Phone VARCHAR(14)DEFAULT NULL,
  Address VARCHAR(256) DEFAULT NULL,
  City VARCHAR(64) DEFAULT NULL,
  PostCode VARCHAR(5) DEFAULT NULL, 
  Availability DATE NOT NULL,
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
CREATE TABLE Documents (
  Id INTEGER PRIMARY KEY AUTO_INCREMENT,
  Titled VARCHAR(64) NOT NULL,
  Address VARCHAR(256) NOT NULL,

  Key_Candidates INTEGER NOT NULL,

  FOREIGN KEY (Key_Candidates) REFERENCES Candidates(Id)
);

-- Qualifications --
CREATE TABLE Qualifications (
  Id INTEGER PRIMARY KEY AUTO_INCREMENT,
  Titled VARCHAR(128) NOT NULL,
  MedicalStaff BOOLEAN DEFAULT FALSE, 
  Abreviation VARCHAR(12) DEFAULT NULL
);
CREATE TABLE Get_qualifications (
  Key_Candidates INTEGER NOT NULL,
  Key_Qualifications INTEGER NOT NULL,

  Date TIMESTAMP NOT NULL, 

  FOREIGN KEY (Key_Candidates) REFERENCES Candidates(Id),
  FOREIGN KEY (Key_Qualifications) REFERENCES Qualifications(Id),

  PRIMARY KEY (Key_Candidates, Key_Qualifications)
);

-- Helps --
CREATE TABLE Helps (
  Id INTEGER PRIMARY KEY AUTO_INCREMENT,
  Titled VARCHAR(64) NOT NULL,
  Description TEXT DEFAULT NULL
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

-- Contracts --
CREATE TABLE Types_of_contracts (
  Id INTEGER PRIMARY KEY AUTO_INCREMENT,
  Titled VARCHAR(64) NOT NULL,
  Description TEXT DEFAULT NULL
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

  CHECK(PropositionDate < StartDate AND StartDate < EndDate),
  CHECK(PropositionDate < SignatureDate AND SignatureDate < EndDate),
  CHECK(StartDate < ResignationDate AND ResignationDate < EndDate)
);

-- Needs --
CREATE TABLE Needs (
  Id INTEGER PRIMARY KEY AUTO_INCREMENT,
  StartDate DATE NOT NULL,
  EndDate DATE DEFAULT NULL,
  StartHour TIME DEFAULT NULL,
  EndHour TIME DEFAULT NULL,
  Description TEXT DEFAULT NULL,

  Key_Jobs INTEGER NOT NULL,
  Key_Types_of_contracts INTEGER NOT NULL,

  FOREIGN KEY (Key_Jobs) REFERENCES Jobs(Id),
  FOREIGN KEY (Key_Types_of_contracts) REFERENCES Types_of_contracts(Id),

  CHECK(StartDate < EndDate),
  CHECK(StartHour < EndHour)
);
CREATE TABLE Involve (
  Key_Needs INTEGER NOT NULL,
  Key_Qualifications INTEGER NOT NULL,

  FOREIGN KEY (Key_Needs) REFERENCES Needs(Id),
  FOREIGN KEY (Key_Qualifications) REFERENCES Qualifications(Id),

  PRIMARY KEY (Key_Needs, Key_Qualifications)
);

-- applications 
CREATE TABLE Sources (
  Id INTEGER PRIMARY KEY AUTO_INCREMENT,
  Titled VARCHAR(64) NOT NULL
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
    (Key_Establishments IS NOT NULL AND Key_Services IS NOT NULL AND Key_Needs IS NULL) OR
    (Key_Needs IS NOT NULL AND Key_Establishments IS NULL AND Key_Services IS NULL)
  )  
);

-- Rendez-vous --
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