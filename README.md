# SAÉ 3.01 - Développement d’une application
## Gestion d'un stock pharmaceutique

### Membres du groupe :
- Marcoux Corentin (marc0237)
- Baudat Louis (baud0157)
- Lobreau Romain (lobr0013)

----
## Installation et configuration du projet

### 1. Installation de Symfony 

- Installation de l'éxécutable de **Symfony** :
  - Environnement **Linux** : ``wget https://get.symfony.com/cli/installer -O - | bash``
  - Environnement **Windows** : 
    - Installation de **Scoop** : 
      ```
      Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
      Invoke-RestMethod -Uri https://get.scoop.sh | Invoke-Expression
      ```
    - Installation de **Symfony** : `scoop install symfony-cli`
- Vérification du bon fonctionnement de l'exécutable **Symfony** : ``symfony self:version``
- Contrôler la compatibilité du system : ``symfony check:requirements  --verbose``
