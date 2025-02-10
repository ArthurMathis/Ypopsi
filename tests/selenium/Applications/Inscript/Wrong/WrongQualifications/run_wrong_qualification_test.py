import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))
sys.path.append(current_dir)

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
    print(VIOLET + "===== Procédure de test avec qualifications incorrectes =====" + RESET)
    
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
    
    print(GREEN + "Procédure Validée" + RESET)
    
if __name__ == "__main__":
    RunEmptyCandidateTest()