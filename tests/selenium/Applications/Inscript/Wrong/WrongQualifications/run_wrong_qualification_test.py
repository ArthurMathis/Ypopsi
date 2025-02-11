import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))

wrong_qualifications_dir = current_dir
wrong_dir                = os.path.dirname(wrong_qualifications_dir)
inscript_dir             = os.path.dirname(wrong_dir)
applications_dir         = os.path.dirname(inscript_dir)
parent_dir               = os.path.dirname(applications_dir)

sys.path.append(current_dir)
sys.path.append(parent_dir)

from define import write

from InscriptCandidatesWrongQualification1 import InscriptCandidatesWrongQualification1
from InscriptCandidatesWrongQualification2 import InscriptCandidatesWrongQualification2
from InscriptCandidatesWrongQualification3 import InscriptCandidatesWrongQualification3
from InscriptCandidatesWrongQualification4 import InscriptCandidatesWrongQualification4
from InscriptCandidatesWrongQualification5 import InscriptCandidatesWrongQualification5
from InscriptCandidatesWrongQualification6 import InscriptCandidatesWrongQualification6

VIOLET = '\033[38;2;128;0;128m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunEmptyCandidateTest():
    write("Procédure de test avec qualifications incorrectes", VIOLET, "subtitle")
    
    test = InscriptCandidatesWrongQualification1()
    test.run() 
    
    test = InscriptCandidatesWrongQualification2()
    test.run()
    
    test = InscriptCandidatesWrongQualification3()
    test.run()
    
    test = InscriptCandidatesWrongQualification4()
    test.run()
    
    test = InscriptCandidatesWrongQualification5()
    test.run()
    
    test = InscriptCandidatesWrongQualification6()
    test.run()
    
    write("Procédure Validée", GREEN, "valid")
    
if __name__ == "__main__":
    RunEmptyCandidateTest()