NFQ Akademija - Gallery
========================

Funkcionalumas
----------------------------------

* Implementuota autorizacijos sistema, su 2 rolėmis (Adminas ir Useris) (naudojant friendsofsymfony/user-bundle).
* Failo įkėlimas į serverį (naudojant vich/uploader-bundle).
* Albumai:
    * Kūrimas.
    * Redagavimas.
    * Trynimas (AJAX).
    * Titulinės nuotraukos priskyrimas.
    * Išvedamas nuotraukų skaičius.
* Nuotraukos:
    * Kūrimas.
        * Viena nuotrauka gali būti priskirta keliems albumams.
    * Redagavimas.
    * Trynimas (AJAX).
    * Komentavimas (AJAX).
        * Komentuoti gali tiek Adminas, tiek Useris.
        * Adminas komentarus gali trinti (AJAX).
    * Patikimas (AJAX).
        * Nuotraukos patikti gali tiek Adminui, tiek Useriui, tiek Svečiui.
        * Patikimai saugomi pagal kompiuterio iš kurio siųstas patikimas IP.
    * Tagų prisegimas (AJAX).
    * Thumbnail`s sukūrimas ir kešavimas (naudojant avalanche123/imagine-bundle).
    * Nuotraukos atvaizduojamos magnific-popup pagalba, per AJAX iškviečiant nuotraukos view`ą.
    * Peržiūrint nuotrauką rodyklių pagalba galima pereiti į buvusią ar sekančią albumo nuotrauką (AJAX).
    * Išvedami komentarų ir patikimų skaičiai.