import os
import sys

sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

from InscriptCandidates import InscriptCandidates
from InscriptCandidatesWithoutAddress import InscriptCandidatesWithoutAddress
from InscriptCandidatesWithoutAddressEmailPhone import InscriptCandidatesWithoutAddressEmailPhone
from InscriptCandidatesWithoutEmail import InscriptCandidatesWithoutEmail
from InscriptCandidatesWithoutEmailPhone import InscriptCandidatesWithoutEmailPhone
from InscriptCandidatesWithoutPhone import InscriptCandidatesWithoutPhone
from InscriptCandidatesWithoutService import InscriptCandidatesWithoutService
from InscriptCandidatesWithoutServiceTypeContract import InscriptCandidatesWithoutServiceTypeContract
from InscriptCandidatesWithoutTypeContract import InscriptCandidatesWithoutTypeContract
from InscriptCandidatesWithQualification import InscriptCandidatesWithQualification
from InscriptCandidatesWithQualifications import InscriptCandidatesWithQualifications

VIOLET = '\033[38;2;128;0;128m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunRightRegisteringTest():
    print(VIOLET + "===== Procédure de test d'inscription =====" + RESET)
    
    test = InscriptCandidates()
    test.run()
    
    test = InscriptCandidatesWithoutAddress()
    test.run()
    
    test = InscriptCandidatesWithoutAddressEmailPhone()
    test.run()
    
    test = InscriptCandidatesWithoutEmail()
    test.run()
    
    test = InscriptCandidatesWithoutEmailPhone()
    test.run()
    
    test = InscriptCandidatesWithoutPhone()
    test.run()
    
    test = InscriptCandidatesWithoutService()
    test.run()
    
    test = InscriptCandidatesWithoutServiceTypeContract()
    test.run()
    
    test = InscriptCandidatesWithoutTypeContract()
    test.run()
    
    test = InscriptCandidatesWithQualification()
    test.run()
    
    test = InscriptCandidatesWithQualifications()
    test.run()
    
    print(GREEN + "Procédure Validée" + RESET)
    
if __name__ == "__main__":
    RunRightRegisteringTest()