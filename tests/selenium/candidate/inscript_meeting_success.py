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
        
        # Cliquer sur l'onglet "Rendez-vous"
        rendezvous_tab = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "//p[text()='Rendez-vous']"))
        )
        rendezvous_tab.click()

        # Cliquer sur le bouton d'inscription
        rendezvous_button = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "//a[contains(@href, 'candidates=input-meetings&key_candidate=')]"))
        )
        rendezvous_button.click()

        # Attendre que la page soit complètement chargée
        time.sleep(0.5) 
        
        # Saisir la date
        date_input = driver.find_element(By.ID, "date")
        date_input.send_keys("2024-11-20") 
        
        # Saisir l'horaire
        time_input = driver.find_element(By.ID, "time")
        time_input.send_keys("10:00")  
        
        # Soumettre le formulaire
        submit_button = driver.find_element(By.XPATH, "//button[@type='submit']")
        submit_button.click()
        
        # Attendre un moment pour voir le résultat
        time.sleep(0.5)

        # Fermer le navigateur
        driver.quit()

if __name__ == "__main__":
    runner = InscriptionMeetingTestRunner()
    runner.run()