import os
import sys

sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))

from RightRegistering.run_right_registering_test import RunRightRegisteringTest

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

def main():
    print(ROSE + "===== Procédure de test de l'inscription des candidats =====" + RESET)

    print(ROSE + "Candidats justes" + RESET)
    RunRightRegisteringTest()
    
    print(ROSE + "Candidats faux" + RESET)
    RunWrongNameTest()
    RunWrongFirstnameTest()
    RunWrongEmailTest()
    RunWrongPhoneTest()
    RunWrongCityTest()    
    RunWrongPostcodeTest()
    
    print(ROSE + "Candidats vides" + RESET)
    RunEmptyCandidateTest()
    
    print(GREEN + "===== Bloc de tests Validé =====" + RESET)

if __name__ == "__main__":
    main()