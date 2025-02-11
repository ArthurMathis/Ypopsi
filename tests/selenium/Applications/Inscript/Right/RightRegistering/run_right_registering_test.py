import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))

right_registering_dir = current_dir
right_dir             = os.path.dirname(right_registering_dir)
inscript_dir          = os.path.dirname(right_dir)
applications_dir      = os.path.dirname(inscript_dir)
parent_dir            = os.path.dirname(applications_dir)

sys.path.append(current_dir)
sys.path.append(parent_dir)

from define import write

from InscriptCandidates import InscriptCandidates
from InscriptCandidatesWithoutAddress import InscriptCandidatesWithoutAddress
from InscriptCandidatesWithoutAddressEmailPhone import InscriptCandidatesWithoutAddressEmailPhone
from InscriptCandidatesWithoutEmail import InscriptCandidatesWithoutEmail
from InscriptCandidatesWithoutEmailPhone import InscriptCandidatesWithoutEmailPhone
from InscriptCandidatesWithoutPhone import InscriptCandidatesWithoutPhone
from InscriptCandidatesWithoutService import InscriptCandidatesWithoutService
from InscriptCandidatesWithoutServiceTypeContract import InscriptCandidatesWithoutServiceTypeContract
from InscriptCandidatesWithoutTypeContract import InscriptCandidatesWithoutTypeContract

VIOLET = '\033[38;2;128;0;128m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunRightRegisteringTest():
    write("Procédure de test d'inscription", VIOLET, "subtitle")
    
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
    
    write("Procédure Validée", GREEN, "valid")
    
if __name__ == "__main__":
    RunRightRegisteringTest()