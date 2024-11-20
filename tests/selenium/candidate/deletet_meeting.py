from tests.selenium.run_test import TestRunner
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait  # Ajout de l'importation
from selenium.webdriver.support import expected_conditions as EC  # Ajout de l'importation
import time

class InscriptionMeetingTestRunner(TestRunner):
    def run(self):
        driver = self.connect() 
        self.goToApplications(driver)
        self.clickOnFirstAplications(driver)
        
        try:
            # Cliquer sur l'onglet "Rendez-vous"
            rendezvous_tab = WebDriverWait(driver, 10).until(
                EC.element_to_be_clickable((By.XPATH, "//p[text()='Rendez-vous']"))
            )
            rendezvous_tab.click()

            

            # Vérifier que l'application a bien enregistré le nouveau rendez-vous
            WebDriverWait(driver, 10).until(
                EC.url_contains("ypopsi/index.php?candidates=delete-meetings&key_meeting=1&key_candidate=") 
            )
            print(f"{self.VERT}Le rendez-vous a été supprimé avec succès.{self.RESET}")

        except Exception as e:
            print(f"{self.ROUGE}Erreur : {str(e)}{self.RESET}")
            return False
        
        # Attendre un moment pour voir le résultat
        time.sleep(0.5)

        # Fermer le navigateur
        driver.quit()

if __name__ == "__main__":
    runner = InscriptionMeetingTestRunner()
    runner.run()