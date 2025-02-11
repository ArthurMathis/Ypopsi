import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))

wrong_dir        = current_dir
inscript_dir     = os.path.dirname(wrong_dir)
applications_dir = os.path.dirname(inscript_dir)
parent_dir       = os.path.dirname(applications_dir)

sys.path.append(current_dir)
sys.path.append(parent_dir)

from define import write

from WrongName.run_wrong_name_test import RunWrongNameTest
from WrongFirstname.run_wrong_firstname_test import RunWrongFirstnameTest
from WrongEmail.run_wrong_email_test import RunWrongEmailTest
from WrongPhone.run_wrong_phone_test import RunWrongPhoneTest
from WrongCity.run_wrong_city_test import RunWrongCityTest
from WrongPostcode.run_wrong_postcode_test import RunWrongPostcodeTest
from EmptyCandidate.run_empty_candidate_test import RunEmptyCandidateTest

ROSE = '\033[38;2;255;192;203m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunWrongInscriptTest():
    write("Procédure de test de l'inscription des candidats - Détection des erreurs", ROSE, "subtitle")

    write("Candidats faux", ROSE)
    RunWrongNameTest()
    RunWrongFirstnameTest()
    RunWrongEmailTest()
    RunWrongPhoneTest()
    RunWrongCityTest()    
    RunWrongPostcodeTest()
    
    write("Candidats vides", ROSE)
    RunEmptyCandidateTest()
    
    write("Bloc de tests Validé", GREEN, "valid")

if __name__ == "__main__":
    RunWrongInscriptTest()