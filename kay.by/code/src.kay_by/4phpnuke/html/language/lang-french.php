<?php

/**************************************************************************/
/* PHP-NUKE: The Future of the Web                                        */
/* ===============================                                        */
/*                                                                        */
/* This is the language module with "all" the system messages sorted by   */
/* modules.                                                               */
/*                                                                        */
/* If you made a translation, please sent to me (fbc@mandrakesoft.com)    */
/* the translated file. Please keep the original text order by modules,   */
/* and just one message per line, also double check your translation!     */
/*                                                                        */
/* You need to change the second quoted phrase, not the capital one!      */
/*                                                                        */
/* If you need to use double quotes (") remember to add a backslash (\),  */
/* so your entry will look like: This is \"double quoted\" text.          */
/* And, if you use HTML code, please double check it.                     */
/**************************************************************************/
/* Previous        : Albert Bruc (al@linuxfrench.net)                     */
/*  translations     Philippe LEVIEZ (pleviez@vintagevw.org)              */
/*                   Fabian Rodriguez (Fabian.Rodriguez@toxik.com)        */
/*                   AmigaPhil (AmigaPhil@ping.be)                        */
/* Last modified by: AmigaPhil (AmigaPhil@ping.be)                        */
/*                                                                        */
/* For updates of this file (lang-french.php) or other translation tools, */
/* please check the French PHP-Nuke portal: http://www.boomtchak.net/     */
/**************************************************************************/

/**************************************************************************/
/* START NEW FIELDS FOR MULTILINGUAL VERSION                              */
/* These fields are only at the top of the file to see what fields should */
/* be added and translated to be used in the multilingual version         */
/* Feel free to re-organise them ... Crocket - http://www.webmasters.be   */
/**************************************************************************/

/* FIELDS USED IN THE PREFERENCES */
define("_MULTILINGUALOPT","Options Multilingue ");
define("_ACTMULTILINGUAL","Activer le système Multilingue ? ");
define("_ACTUSEFLAGS","Montrer drapeaux au lieu du dropdown box? ");

/*****************************************************/
/* NEW ML MESSAGE SYSTEM FIELDS                      */
/*****************************************************/

define("_EDITMSG","Editer message");
define("_ADDMSG","Ajouter message");
define("_ALLMESSAGES","Aperçu messages");
define("_VIEW","Visible à");
define("_REMOVEMSG","Etes-vous sûr de vouloir supprimer ce message ? ");

/**************************************************************************/
/* END NEW FIELDS FOR MULTILINGUAL VERSION                                */
/**************************************************************************/

/*****************************************************/
/* Charset for META Tags                             */
/*****************************************************/

define("_CHARSET","ISO-8859-1");

/*****************************************************/
/* Common texts                                      */
/*****************************************************/

define("_SEND","Envoyer");
define("_URL","URL");
define("_PRINTER","Format imprimable");
define("_FRIEND","Envoyer cet article &agrave; un(e) ami(e)");
define("_SEARCH","Recherche");
define("_LOGIN"," Identification ");
define("_WRITES","a &eacute;crit :");
define("_POSTEDON","Post&eacute; le");
define("_NICKNAME","Surnom/Pseudo");
define("_PASSWORD","Mot de Passe");
define("_WELCOMETO","Bienvenue sur");
define("_EMAIL","E-mail");
define("_REALNAME","Nom r&eacute;el");
define("_FUNCTIONS","Fonctions");
define("_EDIT","Editer");
define("_DELETE","Supprimer");
define("_PREVIOUS","Page Pr&eacute;c&eacute;dente");
define("_NEXT","Page Suivante");
define("_YOURNAME","Votre Nom");
define("_SORTASC","Tri croissant");
define("_SORTDESC","Tri d&eacute;croissant");
define("_POSTEDBY","Transmis par");
define("_CANCEL","Annuler");
define("_YES","Oui");
define("_NO","Non");
define("_ALLTOPICS","Tous les Sujets");
define("_READS","lectures");
define("_CATEGORY","Cat&eacute;gorie");
define("_OTHEROPTIONS","Autres options");
define("_GOBACK","[ <a href=\"javascript:history.go(-1)\">Retour</a> ]");
define("_GOBACK2","En arri&egrave;re");
define("_OPTIONAL","(optionnel)");
define("_REQUIRED","(requis)");
define("_SAVECHANGES","Sauvez les modifications");
define("_RE","Re");
define("_OK","Ok !");
define("_SAVE","Sauver");
define("_ID","ID");

/*****************************************************/
/* Articles texts                                    */
/*****************************************************/

define("_RELATED","Liens connexes");
define("_MOREABOUT","Plus &agrave; propos de");
define("_NEWSBY","Nouvelles transmises par");
define("_MOSTREAD","L'article le plus lu &agrave; propos de");
define("_LASTNEWS","Derni&egrave;res nouvelles &agrave; propos de");
define("_READMORE","Suite...");
define("_BYTESMORE","octets de plus");
define("_COMMENTSQ","commentaires ?");
define("_COMMENT","commentaire");
define("_COMMENTS","commentaires");
define("_PASTARTICLES","Articles pr&eacute;c&eacute;dents");
define("_OLDERARTICLES","Archives");

/*****************************************************/
/* Comments texts (Articles and Polls)               */
/*****************************************************/

define("_CONFIGURE","Pr&eacute;f&eacute;rences");
define("_LOGINCREATE","Connexion/Cr&eacute;er un compte");
define("_THRESHOLD","Disposition");
define("_NOCOMMENTS","Pas de commentaires");
define("_NESTED","Emboit&eacute;s");
define("_FLAT","A plat");
define("_THREAD","Par discussions");
define("_OLDEST","Le plus vieux en premier");
define("_NEWEST","Le plus r&eacute;cent en premier");
define("_HIGHEST","Le plus haut score en premier");
define("_COMMENTSWARNING","Les commentaires sont la propri&eacute;t&eacute; de leurs auteurs. Nous ne sommes pas responsables de leurs contenus !");
define("_SCORE","Score:");
define("_BY","par");
define("_ON","le");
define("_USERINFO","Profil Utilisateur");
define("_READREST","Lire le reste du commentaire...");
define("_REPLY","R&eacute;pondre &agrave; ce message");
define("_REPLYMAIN","Poster un commentaire");
define("_NOSUBJECT","Pas de Sujet");
define("_NOANONCOMMENTS","Les commentaires anonymes ne sont pas autoris&eacute;s, veuillez vous <a href=\"user.php\">enregistrer</a>");
define("_PARENT","Parent");
define("_ROOT","Racine");
define("_LOGOUT","Sortie");
define("_UCOMMENT","Commentaire");
define("_ALLOWEDHTML","HTML autoris&eacute;:");
define("_POSTANON","Publication anonyme");
define("_EXTRANS","Extrans (html tags en texte)");
define("_HTMLFORMATED","Format HTML");
define("_PLAINTEXT","Texte seulement");
define("_ONN","le...");
define("_SUBJECT","Sujet");
define("_DUPLICATE","En double. L'avez-vous soumis deux fois ?");
define("_COMMENTSBACK","Retour aux commentaires");
define("_COMMENTREPLY","Commenter");
define("_COMREPLYPRE","Pr&eacute;visualisation du commentaire");
define("_SURVEYCOM","Poster un commentaire sur le sondage");
define("_SURVEYCOMPRE","Pr&eacute;visualisation du commentaire");
define("_NOTRIGHT","Quelque chose s'est mal d&eacute;roul&eacute; en passant une variable &agrave; cette fonction. Ceci est un message d'avertissement pour pr&eacute;venir d'un probable disfonctionnement.");
define("_DIRECTCOM","Commentaire direct...");
define("_SENDAMSG","Envoyer un message");

/*****************************************************/
/* Send to Friend and Recommend us texts             */
/*****************************************************/

define("_YOUSENDSTORY","Vous allez envoyer l'article");
define("_TOAFRIEND","&agrave; l'ami(e) suivant(e):");
define("_FYOURNAME","Votre nom:");
define("_FYOUREMAIL","Votre E-mail:");
define("_FFRIENDNAME","Nom de votre ami(e):");
define("_FFRIENDEMAIL","E-mail de votre ami(e):");
define("_INTERESTING","Lu sur");
define("_HELLO","Bonjour");
define("_YOURFRIEND","Votre ami(e)");
define("_CONSIDERED","a trouvé l'article suivant intéressant et a souhaité vous l'envoyer.");
define("_FDATE","Date:");
define("_FTOPIC","Sujet:");
define("_YOUCANREAD","Vous pouvez lire d'autres articles intéressant sur");
define("_FSTORY","L'article");
define("_HASSENT"," a &eacute;t&eacute; envoy&eacute; &agrave;");
define("_THANKS","Merci!");
define("_RECOMMEND","Recommander ce site &agrave; un(e) ami(e)");
define("_INTSITE","Site intéressant:");
define("_OURSITE","estime notre site");
define("_INTSENT","intéressant et a souhaité vous en parler.");
define("_FSITENAME","Nom du Site:");
define("_FSITEURL","URL du Site:");
define("_FREFERENCE","La r&eacute;f&eacute;rence &agrave; notre site a &eacute;t&eacute; envoy&eacute;e &agrave;");
define("_THANKSREC","Merci de nous avoir recommand&eacute;!");
define("_PDATE","Date:");
define("_PTOPIC","Sujet:");
define("_COMESFROM","Cet article provient de");
define("_THEURL","L'URL de cet article est:");

/*****************************************************/
/* Mainfile texts                                    */
/*****************************************************/

define("_MPROBLEM","Une erreur s'est produite !");
define("_CATEGORIES","cat&eacute;gories");
define("_WAITINGCONT","Contenu en attente");
define("_SUBMISSIONS","Propositions");
define("_WREVIEWS","Comptes rendus en attente");
define("_WLINKS","Liens en attente");
define("_EPHEMERIDS","Eph&eacute;m&eacute;rides");
define("_ONEDAY","Un Jour comme Aujourd'hui...");
define("_ASREGISTERED","Vous n'avez pas encore de compte?<br><a href=\"user.php\">Enregistrez vous !</a><br>En tant que membre enregistr&eacute;, vous b&eacute;n&eacute;ficierez de privil&egrave;ges tels que: changer le th&egrave;me de l'interface, modifier la disposition des commentaires, signer vos interventions, ...");
define("_MENUFOR","Menu de");
define("_NOBIGSTORY","Il n'y a pas encore d'article-phare aujourd'hui.");
define("_BIGSTORY","Aujourd'hui, l'article le plus lu est:");
define("_TODAYBIG","Article-phare du jour");

/*****************************************************/
/* Polls System texts                                */
/*****************************************************/

define("_SURVEY","Sondage");
define("_PASTSURVEYS","Derniers Sondages");
define("_POLLS","Sondages");
define("_PCOMMENTS","Commentaires:");
define("_RESULTS","R&eacute;sultats");
define("_LVOTES","votes");
define("_TOTALVOTES","Total des votes:");
define("_ONEPERDAY","Un seul vote par jour est permis");
define("_VOTING","Isoloir");
define("_OTHERPOLLS","Autres Sondages");
define("_CURRENTSURVEY","Sondage en cours");
define("_CURRENTPOLLRESULTS","R&eacute;sultats du sondage en cours");

/*****************************************************/
/* Headlines texts                                   */
/*****************************************************/

define("_HREADMORE","suite...");

/*****************************************************/
/* Who's Online                                      */
/*****************************************************/

define("_CURRENTLY","Il y a pour le moment");
define("_GUESTS","invit&eacute;(s) et");
define("_MEMBERS","membre(s) en ligne.");
define("_WHOSONLINE","Qui est en ligne ?");
define("_YOUARELOGGED","Vous &ecirc;tes connect&eacute; en tant que");
define("_YOUHAVE","Vous avez");
define("_PRIVATEMSG","message(s) priv&eacute;(s).");
define("_YOUAREANON","Vous &ecirc;tes un visiteur anonyme. Vous pouvez vous enregistrer gratuitement en cliquant <a href=\"user.php\">ici</a>.");

/*****************************************************/
/* Members List texts                                */
/*****************************************************/

define("_MEMBERSLIST","- Liste des membres");
define("_GREETINGS","Bienvenue &agrave; notre dernier membre enregistr&eacute;:");
define("_SORTBY","Tri&eacute; par:");
define("_MNICKNAME","pseudo");
define("_MREALNAME","nom");
define("_MEMAIL","E-mail");
define("_MURL","URL");
define("_ONLINEREG","Nombre d'utilisateurs enregistr&eacute;s en ligne en ce moment:");
define("_WEHAVE","Nous avons");
define("_MREGISTERED","utilisateurs enregistr&eacute;s jusqu'&agrave; pr&eacute;sent.  Il y a");
define("_MREGONLINE","utilisateur(s) enregistr&eacute;(s) en ligne en ce moment.");
define("_REGSOFAR","utilisateurs enregistr&eacute;s jusqu'&agrave; pr&eacute;sent.");
define("_USERSFOUND","utilisateurs trouv&eacute;s pour");
define("_MPAGES","pages");
define("_USERSSHOWN","utilisateurs affich&eacute;s");
define("_NOMEMBERS","Pas de membre trouv&eacute; pour");

/*****************************************************/
/* Reviews texts                                     */
/*****************************************************/

define("_WRITEREVIEW","Ecrire un compte rendu");
define("_WRITEREVIEWFOR","Ecrire un compte rendu pour");
define("_ENTERINFO","Veuillez entrer les informations correspondantes aux sp&eacute;cifications");
define("_PRODUCTTITLE","Titre du produit");
define("_NAMEPRODUCT","Nom du produit examin&eacute;.");
define("_REVIEW","Compte rendu");
define("_CHECKREVIEW","Votre compte rendu actuel. Veuillez respecter une grammaire correcte! Utilisez au moins une centaine de mots, d'accord? Vous pouvez aussi employer les tags HTML si vous savez comment les utiliser.");
define("_FULLNAMEREQ","Votre nom complet. Requis.");
define("_REMAIL","Votre Email");
define("_REMAILREQ","Votre adresse e-mail. Requise.");
define("_SELECTSCORE","Score pour ce produit");
define("_RELATEDLINK","Lien en relation");
define("_PRODUCTSITE","Site Web officiel du produit. Assurez-vous que l'URL commence par \"http://\"");
define("_LINKTITLE","Titre du lien");
define("_LINKTITLEREQ","Requis si vous avez un lien associ&eacute;, optionnel sinon.");
define("_RIMAGEFILE","Nom du fichier image");
define("_RIMAGEFILEREQ","Nom de l'image de couverture, localis&eacute;e dans images/reviews/. Optionnel.");
define("_CHECKINFO","Veuillez vous assurer que l'information entr&eacute;e est 100% correcte et respecte la grammaire et la capitalisation. N'entrez pas votre texte enti&egrave;rement en majuscule: il sera rejet&eacute;.");
define("_INVALIDTITLE","Titre non valide... Ne peut pas &ecirc;tre &agrave; blanc");
define("_INVALIDSCORE","Score non valide... Doit &ecirc;tre compris entre 1 et 10");
define("_INVALIDTEXT","Texte de compte-rendu non valide... Ne peut pas &ecirc;tre &agrave; blanc");
define("_INVALIDHITS","Le nombre de hits doit &ecirc;tre un entier positif");
define("_CHECKNAME","Vous devez entrer ET votre nom, ET votre e-mail");
define("_INVALIDEMAIL","E-mail invalide (ex.: vous@yahoo.com)");
define("_INVALIDLINK","Vous devez entrer &agrave; la fois ET le titre du lien, ET l'URL du lien; ou laisser les 2 champs vides");
define("_ADDED","Ajout&eacute;:");
define("_REVIEWER","Critique:");
define("_REVIEWID","ID du compte rendu");
define("_HITS","Hits");
define("_LOOKSRIGHT","Ceci est-il correct ?");
define("_RMODIFIED","modifi&eacute;");
define("_RADDED","ajout&eacute;");
define("_NOTE","Note:");
define("_ADMINLOGGED","Connect&eacute; en tant qu'administrateur... Ce compte rendu sera imm&eacute;diatement");
define("_RTHANKS","Merci pour votre proposition de compte rendu");
define("_MODIFICATION","modification");
define("_ISAVAILABLE","Il est maintenant disponible dans notre banque de donn&eacute;es.");
define("_EDITORWILLLOOK","Les &eacute;diteurs vont examiner votre compte rendu. Il sera disponible prochainement!");
define("_RBACK","Retour &agrave; l'index des comptes rendus");
define("_RWELCOME","Bienvenue dans la rubrique des comptes rendus");
define("_10MOSTPOP","10 comptes rendus les plus populaires");
define("_10MOSTREC","10 comptes rendus les plus r&eacute;cents");
define("_THEREARE","Il y a");
define("_REVIEWSINDB","comptes rendus dans la base de donn&eacute;es.");
define("_REVIEWS","Comptes rendus");
define("_REVIEWSLETTER","Comptes rendus pour la lettre");
define("_NOREVIEWS","Il n'y a pas de comptes rendus pour la lettre");
define("_TOTALREVIEWS","Total des comptes rendus trouv&eacute;s.");
define("_RETURN2MAIN","Retour au menu principal");
define("_REVIEWCOMMENT","Commentaire sur le compte rendu:");
define("_YOURNICK","Votre pseudo:");
define("_RCREATEACCOUNT","<a href=\"user.php\">Cr&eacute;er</a> un compte");
define("_YOURCOMMENT","Votre commentaire:");
define("_MYSCORE","Mon score:");
define("_ADMIN","Admin:");
define("_REVIEWMOD","Modification du compte rendu");
define("_RDATE","Date:");
define("_RTITLE","Titre:");
define("_RTEXT","Texte:");
define("_REVEMAIL","E-mail:");
define("_RLINK","Lien:");
define("_RLINKTITLE","Titre du lien:");
define("_COVERIMAGE","Image de couverture:");
define("_PREMODS","Pr&eacute;visualisation des modifications");

/*****************************************************/
/* Search texts                                      */
/*****************************************************/

define("_SEARCHUSERS","Rechercher dans la base de donn&eacute;es des utilisateurs");
define("_SEARCHSECTIONS","Rechercher dans les rubriques sp&eacute;ciales");
define("_SEARCHREVIEWS","Rechercher dans les comptes rendus");
define("_SEARCHIN","Rechercher dans");
define("_ARTICLES","Articles");
define("_ALLAUTHORS","Tous les Auteurs");
define("_ALL","Tous");
define("_WEEK","semaine");
define("_WEEKS","semaines");
define("_MONTH","mois");
define("_MONTHS","mois");
define("_SEARCHON","Chercher dans:");
define("_SSTORIES","Articles");
define("_SSECTIONS","Rubriques");
define("_SUSERS","Utilisateurs");
define("_NOMATCHES","Aucune correspondance trouv&eacute;e &agrave; votre requ&ecirc;te");
define("_PREVMATCHES","R&eacute;ponses Pr&eacute;c&eacute;dentes");
define("_NEXTMATCHES","R&eacute;ponses Suivantes");
define("_INSECTION","dans la rubrique");
define("_NONAME","Pas de nom saisi");
define("_SCOMMENTS","Commentaires");
define("_SEARCHRESULTS","R&eacute;sultats de la recherche");
define("_CONTRIBUTEDBY","Contribution de");
define("_UCOMMENTS","Commentaires");
define("_MATCHTITLE","Concordance dans le titre");
define("_MATCHTEXT","Concordance dans le texte de l'article");
define("_MATCHBOTH","Concordance dans le titre et dans le texte de l'article");
define("_SREPLY","R&eacute;pondre");
define("_SREPLIES","R&eacute;ponses");
define("_ATTACHART","Attach&eacute; &agrave; l'article");
define("_PAGES","Pages");
define("_REVIEWSCORE","Score pour ce compte rendu");

/*****************************************************/
/* Special Sections texts                            */
/*****************************************************/

define("_SECWELCOME","Bienvenue dans la Rubrique Sp&eacute;ciale de");
define("_YOUCANFIND","Vous trouverez ici quelques articles cools non pr&eacute;sent&eacute;s sur la page d'acceuil.");
define("_THISISSEC","Ceci est la rubrique");
define("_FOLLOWINGART","Suivre les articles &eacute;dit&eacute;s sous cette rubrique.");
define("_SECRETURN","Retour &agrave; l'index des rubriques");
define("_TOTALWORDS","total des mots dans ce texte");
define("_BACKTO","Retour");
define("_SECINDEX","Index des Rubriques");
define("_PAGE","Page");
define("_PAGEBREAK","Si vous voulez plusieurs pages, vous pouvez &eacute;crire <b>&lt;!--pagebreak--&gt;</b> l&agrave; o&ugrave; vous voulez un saut de page.");
define("_DONTSELECT","Note: Ne s&eacute;lectionnez aucune rubrique pour stocker le texte &agrave; publier plus tard.");

/*****************************************************/
/* Stats texts                                       */
/*****************************************************/

define("_WERECEIVED","Nous avons re&ccedil;us");
define("_PAGESVIEWS","pages vues depuis");
define("_BROWSERS","Navigateurs");
define("_OPERATINGSYS","Syst&egrave;mes d'exploitations");
define("_UNKNOWN","Inconnus");
define("_OTHER","Autres / Inconnus");
define("_MISCSTATS","Statistiques Diverses");
define("_REGUSERS","Utilisateurs enregistr&eacute;s:");
define("_ACTIVEAUTHORS","auteurs/mod&eacute;rateurs les plus actifs");
define("_STORIESPUBLISHED","Articles publi&eacute;s:");
define("_SACTIVETOPICS","Sujets actifs:");
define("_COMMENTSPOSTED","Commentaires post&eacute;s:");
define("_SSPECIALSECT","Rubriques sp&eacute;ciales:");
define("_ARTICLESSEC","Articles dans les rubriques:");
define("_LINKSINLINKS","Liens Web dans notre annuaire:");
define("_LINKSCAT","Cat&eacute;gories de liens:");
define("_NEWSWAITING","Nouvelles en attente de publication:");
define("_NUKEVERSION","PHP-Nuke Version:");
define("_SEARCHENGINES","Moteurs de recherche");
define("_BOTS","Robots/Spiders");
define("_STATS","Statistiques sur les acc&egrave;s");

/*****************************************************/
/* Submit texts                                      */
/*****************************************************/

define("_SUBMITNEWS","Proposer un article");
define("_SUBMITADVICE","Veuillez &eacute;crire votre article/nouvelle en compl&egrave;tant le formulaire suivant, et v&eacute;rifier une seconde fois votre texte.<br>Les propositions ne sont pas toutes publi&eacute;es.<br>Votre proposition sera v&eacute;rifi&eacute;e au niveau de la grammaire et pourrait &ecirc;tre &eacute;dit&eacute;e par notre &eacute;quipe.");
define("_SUBTITLE","Titre");
define("_BEDESCRIPTIVE","Soyez descriptif, simple et clair");
define("_BADTITLES","Ex. de mauvais titres: 'Lisez ceci !' ou 'Un article'");
define("_TOPIC","Sujet");
define("_ARTICLETEXT","Text de l'article:");
define("_HTMLISFINE","le HTML c'est bien, mais contr&ocirc;lez vos URLs et tags HTML!");
define("_AREYOUSURE","Etes-vous s&ucirc;r d'inclure un URL ? Avez-vous verifi&eacute; la typo. ?");
define("_SUBPREVIEW","Vous devez pr&eacute;visualiser avant de pouvoir soumettre");
define("_SELECTTOPIC","S&eacute;lectionnez un Sujet");
define("_NEWSUBPREVIEW","Pr&eacute;visualisation de la proposition");
define("_STORYLOOK","Votre article/nouvelle ressemblera &agrave; ceci:");
define("_CHECKSTORY","Veuillez re-v&eacute;rifier votre texte, les liens, etc, avant d'envoyer votre article !");
define("_THANKSSUB","Merci pour votre proposition!");
define("_SUBSENT","Nous avons re&ccedil;u votre article...");
define("_SUBTEXT","Nous examinerons votre proposition dans quelques heures; si elle est int&eacute;ressante et '&agrave; propos', nous la publierons prochainement.");
define("_WEHAVESUB","En ce moment, nous avons");
define("_WAITING","proposition(s) en attente de publication.");
define("_PREVIEW","Prévisualisation");

/*****************************************************/
/* Topics Page texts                                 */
/*****************************************************/

define("_ACTIVETOPICS","Sujets actifs");
define("_CLICK2LIST","Cliquez pour voir la liste des articles de ce sujet");

/*****************************************************/
/* TOP Page texts                                    */
/*****************************************************/

define("_TOPWELCOME","Bienvenue au classement TOP de");
define("_READSTORIES","articles les plus lus");
define("_COMMENTEDSTORIES","articles les plus comment&eacute;s");
define("_ACTIVECAT","cat&eacute;gories les plus actives");
define("_READSECTION","articles les plus lus dans les rubriques sp&eacute;ciales");
define("_NEWSSUBMITTERS","utilisateurs les plus actifs (Articles)");
define("_NEWSSENT","nouvelles envoy&eacute;es");
define("_VOTEDPOLLS","votes les plus importants sur les sondages");
define("_MOSTACTIVEAUTHORS","auteurs/mod&eacute;rateurs les plus actifs");
define("_NEWSPUBLISHED","nouvelles publi&eacute;es");
define("_READREVIEWS","comptes rendus les plus lus");
define("_DOWNLOADEDFILES","fichiers les plus t&eacute;l&eacute;charg&eacute;s");
define("_DOWNLOADS","fichiers");

/*****************************************************/
/* User's System texts                               */
/*****************************************************/

define("_ERRORINVEMAIL","ERREUR: Email non valide");
define("_ERROREMAILSPACES","ERREUR: Les adresses Email ne contiennent pas d'espacements");
define("_ERRORINVNICK","ERREUR: Pseudo invalide");
define("_NICK2LONG","Le pseudo est trop long. Il doit faire moins de 25 caract&egrave;res");
define("_NAMERESERVED","ERREUR: Ce nom est r&eacute;serv&eacute;");
define("_NICKNOSPACES","ERREUR: Il ne peut pas y avoir d'espaces dans le pseudo");
define("_NICKTAKEN","ERREUR: Ce pseudo est d&eacute;j&agrave; utilis&eacute;");
define("_EMAILREGISTERED","ERREUR: Adresse e-mail d&eacute;j&agrave; enregistr&eacute;e");
define("_UUSERNAME","Nom de l'utilisateur");
define("_FINISH","Valider");
define("_YOUUSEDEMAIL","Vous (ou quelqu'un d'autre) avez utilis&eacute; votre compte d'e-mail");
define("_TOREGISTER","pour ouvrir un compte sur");
define("_FOLLOWINGMEM","Voici les informations du membre:");
define("_UNICKNAME","-Pseudo:");
define("_UPASSWORD","-Mot de Passe:");
define("_USERPASS4","Mot de Passe Utilisateur pour");
define("_YOURPASSIS","Votre mot de passe est:");
define("_2CHANGEINFO","Pour changer vos donn&eacute;es");
define("_YOUAREREGISTERED","Vous &ecirc;tes maintenant enregistr&eacute;. Vous allez recevoir un code de confirmation dans votre boite aux lettres.");
define("_THISISYOURPAGE","C'est votre page personnelle. Vous voulez probablement changer quelque chose. Si vous souhaitez perdre un peu de temps, c'est l'endroit indiqu&eacute;. ");
define("_AVATAR","Avatar");
define("_WEBSITE","Site Web");
define("_ICQ","ICQ");
define("_AIM","AIM");
define("_YIM","YIM");
define("_MSNM","MSNM");
define("_LOCATION","Localisation");
define("_OCCUPATION","Occupation");
define("_INTERESTS","Centres d'int&eacute;r&ecirc;ts");
define("_SIGNATURE","Signature");
define("_MYHOMEPAGE","Ma HomePage:");
define("_MYEMAIL","Mon adresse Email:");
define("_EXTRAINFO","Autres...");
define("_NOINFOFOR","Il n'y a pas d'informations disponibles pour");
define("_LAST10COMMENTS","Les 10 derniers commentaires de");
define("_LAST10SUBMISSIONS","Les 10 derniers articles envoy&eacute;s par");
define("_LOGININCOR","Login Incorrect! Essayez &agrave; nouveau...");
define("_USERLOGIN","Identification Utilisateur");
define("_USERREGLOGIN","Enregistrement/connexion utilisateur");
define("_REGNEWUSER","Enregistrement d'un nouvel utilisateur");
define("_LIST","Liste");
define("_NEWUSER","Nouvel Utilisateur");
define("_PASSWILLSEND","(Le mot de passe sera envoy&eacute; &agrave; l'adresse Email que vous avez entr&eacute;.)");
define("_COOKIEWARNING","Remarque: Les pr&eacute;f&eacute;rences d'un compte reposent sur les cookies.");
define("_ASREGUSER","En tant qu'utilisateur enregistr&eacute; vous pouvez:");
define("_ASREG1","Poster des commentaires en votre nom");
define("_ASREG2","Proposer des articles en votre nom");
define("_ASREG3","Avoir un menu personnalis&eacute;");
define("_ASREG4","S&eacute;lectionner le nombre d'articles que vous voulez voir affich&eacute;s &agrave; l'&eacute;cran");
define("_ASREG5","Personnaliser les commentaires");
define("_ASREG6","Choisir un th&egrave;me visuel diff&eacute;rent");
define("_ASREG7","Et plein d'autres choses encore...");
define("_REGISTERNOW","Enregistrez vous ! C'est gratuit!");
define("_WEDONTGIVE","Nous ne vendons, ni ne communiquons vos informations personnelles &agrave; autrui.");
define("_ALLOWEMAILVIEW","Autoriser les autres utilisateurs &agrave; voir mon adresse Email");
define("_OPTION","Option");
define("_PASSWORDLOST","Vous avez perdu votre mot de passe ?");
define("_NOPROBLEM","Pas de probl&egrave;me. Entrez votre pseudo et cliquez sur le bouton envoyer. Nous vous enverrons un Email automatique avec votre code de confirmation.  R&eacute;-entrez ensuite votre pseudo et votre code de confirmation et nous vous enverrons votre nouveau mot de passe.");
define("_CONFIRMATIONCODE","Code de confirmation");
define("_SENDPASSWORD","Envoyer");
define("_YOUARELOGGEDOUT","Vous &ecirc;tes maintenant d&eacute;connect&eacute; !");
define("_EMAILALREADYEXIST","ERREUR: Adresse e-mail d&eacute;j&agrave; enregistr&eacute;e");
define("_SORRYNOUSERINFO","D&eacute;sol&eacute;, aucune information correspondante pour cet utlilisateur");
define("_USERACCOUNT","Le compte Utilisateur");
define("_AT","de");
define("_HASTHISEMAIL"," est associ&eacute; &agrave; votre e-mail.");
define("_AWEBUSERFROM","Un utilisateur de");
define("_HASREQUESTED","a demand&eacute; que le mot de passe lui soit envoy&eacute;.");
define("_YOURNEWPASSWORD","Votre nouveau mot de passe est:");
define("_YOUCANCHANGE","Vous pourrez le modifier apr&egrave;s vous &ecirc;tre connect&eacute;");
define("_IFYOUDIDNOTASK","Si vous n'avez pas demand&eacute; ceci, ne vous inqui&egrave;tez pas. VOUS voyez ce message, pas 'eux'.  S'il s'agit d'une erreur, il vous suffit de vous connecter avec votre nouveau mot de passe.");
define("_UPDATEFAILED","Mise &agrave; jour de l'entr&eacute;e utilisateur impossible.  Veuillez contacter l'administrateur du site.");
define("_PASSWORD4","Mot de Passe");
define("_MAILED","Envoy&eacute;.");
define("_CODEREQUESTED"," a demand&eacute; un code de confirmation pour changer le mot de passe.");
define("_YOURCODEIS","Votre code de confirmation est:");
define("_WITHTHISCODE","Avec ce code vous pouvez maintenant g&eacute;n&eacute;rer un nouveau mot de passe &agrave; ");
define("_IFYOUDIDNOTASK2","Si vous n'avez pas demandé ceci, pas de panique; effacez simplement ce mail.");
define("_CODEFOR","Code de confirmation pour");
define("_USERPASSWORD4","Mot de Passe Utilisateur pour");
define("_UREALNAME","Nom r&eacute;el");
define("_UREALEMAIL","E-mail r&eacute;el");
define("_EMAILNOTPUBLIC","(Cette adresse e-mail n'est pas publique, mais elle nous servira &agrave; vous renvoyer votre mot de passe si vous le perdiez)");
define("_UFAKEMAIL","E-mail factice");
define("_EMAILPUBLIC","(Cet e-mail sera public. Tapez juste ce que vous voulez, pour N.... les Spammeurs ;-)");
define("_YOURHOMEPAGE","Votre page d'accueil");
define("_YOURAVATAR","Votre avatar");
define("_YICQ","Votre ID ICQ");
define("_YAIM","Votre ID AIM");
define("_YYIM","Votre ID YIM");
define("_YMSNM","Votre ID MSNM");
define("_YLOCATION","Votre domicile");
define("_YOCCUPATION","Vos occupations");
define("_YINTERESTS","Vos centres d'int&eacute;r&ecirc;ts");
define("_255CHARMAX","(Max. 255 caract&egrave;res pour votre signature, HTML compris)");
define("_CANKNOWABOUT","(255 caract&egrave;res max. parlez nous de vous (les autres peuvent lire ce texte).)");
define("_TYPENEWPASSWORD","(entrez 2 fois votre nouveau mot de passe)");
define("_SOMETHINGWRONG","Quelque chose a foir&eacute;...Ca vous &eacute;nerve ? non?");
define("_PASSDIFFERENT","Les mots de passe doivent &ecirc;tre identiques.");
define("_YOURPASSMUSTBE","D&eacute;sol&eacute;, votre mot de passe doit contenir au moins");
define("_CHARLONG","caract&egrave;res");
define("_AVAILABLEAVATARS","Liste des avatars disponibles");
define("_NEWSINHOME","Nombre de nouvelles sur la page d'accueil");
define("_MAX127","(max. 127):");
define("_ACTIVATEPERSONAL","Activez votre Menu Personnel");
define("_CHECKTHISOPTION","(V&eacute;rifiez cette option et le texte suivant appara&icirc;tra dans la fen&ecirc;tre)");
define("_YOUCANUSEHTML","(Vous pouvez utiliser le code HTML pour cr&eacute;er un lien, par exemple)");
define("_SELECTTHEME","Selectionnez un th&egrave;me");
define("_THEMETEXT1","Cette option changera le look pour le site entier.");
define("_THEMETEXT2","Les modifications seront seulement effectives pour vous.");
define("_THEMETEXT3","Chaque Utilisateur peut voir le site avec un th&egrave;me diff&eacute;rent.");
define("_DISPLAYMODE","Mode d'affichage");
define("_SORTORDER","Ordonn&eacute;");
define("_COMMENTSWILLIGNORED","Les commentaires enregistr&eacute;s dans la configuration seront ignor&eacute;s.");
define("_UNCUT","Tous les commentaires");
define("_EVERYTHING","Quasiment Tous");
define("_FILTERMOSTANON","filtrer plus d'anonymes");
define("_USCORE","Score");
define("_SCORENOTE","Les envois anonymes commencent &agrave; 0, le d&eacute;but des envois logu&eacute;s &agrave; 1. Les mod&eacute;rateurs ajoutent et soustraient les points.");
define("_NOSCORES","Ne pas montrer les scores");
define("_HIDDESCORES","(Cache les scores: Ils sont toujours appliqu&eacute;s, mais vous ne les voyez plus.)");
define("_MAXCOMMENT","Longueur maximale du Commentaire");
define("_TRUNCATES","(Troncage des commentaires,Et rajout d'un lien 'Lire la Suite'.)");
define("_BYTESNOTE","octets (1024 octets = 1K)");
define("_USENDPRIVATEMSG","Envoyer un message priv&eacute; &agrave;");
define("_THEMESELECTION","Selection d'un th&egrave;me");
define("_COMMENTSCONFIG","Configuration des commentaires");
define("_HOMECONFIG","Configuration de la page d'accueil");
define("_PERSONALINFO","Informations personnelles");
define("_USERSTATUS","Status actuel de l'utilisateur");
define("_ONLINE","En ligne");
define("_OFFLINE","Hors ligne");
define("_CHANGEYOURINFO","Changer vos donn&eacute;es");
define("_CONFIGCOMMENTS","R&eacute;glage des commentaires");
define("_CHANGEHOME","Changer votre Home Page");
define("_LOGOUTEXIT","D&eacute;connexion/Sortie");
define("_SELECTTHETHEME","Selectionnez un th&egrave;me");

/*****************************************************/
/* FAQ texts                                         */
/*****************************************************/

define("_FAQ2","FAQ (Foire Aux Questions)");
define("_BACKTOTOP","Retour au d&eacute;but");
define("_BACKTOFAQINDEX","Retour &agrave; l'index FAQ");

/*****************************************************/
/* Downloads texts                                   */
/*****************************************************/

define("_FILEINFO","Information Fichier");
define("_CHECK","V&eacute;rifiez");
define("_AUTHORNAME","Nom de l'auteur");
define("_AUTHOREMAIL","Email de l'auteur");
define("_DOWNLOADNAME","Nom du fichier");
define("_ADDTHISFILE","Ajouter ce fichier");
define("_INBYTES","en octets");
define("_PROGRAMNAME","Nom du programme");
define("_FILESIZE","Taille");
define("_VERSION","Version");
define("_UPLOADDATE","Date du t&eacute;l&eacute;versement");
define("_DESCRIPTION","Description");
define("_UDOWNLOADS","T&eacute;l&eacute;chargements");
define("_AUTHOR","Auteur");
define("_HOMEPAGE","Page d'accueil");
define("_DOWNLOADNOW","T&eacute;l&eacute;charger ce fichier maintenant !");
define("_SELECTCATEGORY","S&eacute;lectionnez le dossier-cat&eacute,gorie");
define("_ALLFILES","Tous les fichiers");
define("_INFO","Info");
define("_DISPLAYFILTERED","Affichage filtr&eacute; avec");
define("_SORTED","tri&eacute;");
define("_ASCENDING","Croissant");
define("_DESCENDING","D&eacute;croissant");
define("_NAME","Nom");
define("_CREATIONDATE","Date de cr&eacute;ation");
define("_DOWNLOADSECTION","Rubrique T&eacute;l&eacute;chargement");
define("_NOSUCHFILE","Ce fichier n'existe pas...");
define("_RATERESOURCE","Evaluer un fichier");
define("_FILEURL","Lien vers le fichier");
define("_ADDDOWNLOAD","Ajouter un fichier t&eacute;l&eacute;chargeable");
define("_DOWNLOADSMAIN","T&eacute;l&eacute;chargement - Page principale");
define("_DOWNLOADCOMMENTS","T&eacute;l&eacute;chargement - Commentaires");
define("_DOWNLOADSMAINCAT","T&eacute;l&eacute;chargement - Cat&eacute;gories principales");
define("_ADDADOWNLOAD","Ajouter un nouveau fichier");
define("_DSUBMITONCE","Veuillez ne soumettre un m&ecirc;me fichier qu'une seule fois.");
define("_DPOSTPENDING","Tous les fichiers sont publi&eacute;s apr&egrave;s v&eacute;rification.");
define("_RESSORTED","Les fichiers sont actuellement tri&eacute;s par");
define("_DOWNLOADSNOTUSER1","Vous n'&ecirc;tes pas un utilisateur enregistr&eacute;, ou vous ne vous &ecirc;tes pas connect&eacute;.");
define("_DOWNLOADSNOTUSER2","Si vous &eacute;tiez un utilisateur enregistr&eacute;, vous pourriez proposer vos fichiers en t&eacute;l&eacute;chargement depuis ce site.");
define("_DOWNLOADSNOTUSER3","Devenir un membre enregistr&eacute; est un processus simple et rapide.");
define("_DOWNLOADSNOTUSER4","Pourquoi l'enregistrement est-il n&eacute;cessaire pour acc&eacute;der &agrave; certaines options ?");
define("_DOWNLOADSNOTUSER5","Nous pouvons vous offrir de cette mani&egrave;re un contenu de la plus haute qualit&eacute;,");
define("_DOWNLOADSNOTUSER6","chaque &eacute;l&eacute;ment est examin&eacute; individuellement et approuv&eacute; par notre &eacute;quipe.");
define("_DOWNLOADSNOTUSER7","Nous esp&eacute;rons vous offrir ainsi uniquement des informations de valeur.");
define("_DOWNLOADSNOTUSER8","<a href=\"user.php\">Ouvrir un compte</a>");
define("_DOWNLOADALREADYEXT","ERREUR: Cet URL est d&eacute;j&agrave; pr&eacute;sent dans la base de donn&eacute;es!");
define("_DOWNLOADNOTITLE","ERREUR: Vous devez saisir un TITRE pour votre URL!");
define("_DOWNLOADNOURL","ERREUR: Vous devez saisir un URL pour votre URL!");
define("_DOWNLOADNODESC","ERREUR: Vous devez saisir une DESCRIPTION pour votre URL!");
define("_DOWNLOADRECEIVED","Nous avons re&ccedil;u votre proposition de fichier. Merci !");
define("_NEWDOWNLOADS","Nouveaux fichiers");
define("_TOTALNEWDOWNLOADS","Total des nouveaux fichiers");
define("_DTOTALFORLAST","Total des nouveaux fichiers depuis");
define("_DBESTRATED","Les produits les mieux cot&eacute;s - Top");
define("_TRATEDDOWNLOADS","fichiers &eacute;valu&eacute;s au total");
define("_DLALSOAVAILABLE","T&eacute;l&eacute;chargement &eacute;galement disponible sous");
define("_SORTDOWNLOADSBY","Trier les fichiers par");
define("_DCATNEWTODAY","Nouveaux fichiers dans cette cat&eacute;gorie ajout&eacute;s aujourd'hui");
define("_DCATLAST3DAYS","Nouveaux fichiers dans cette cat&eacute;gorie ajout&eacute;s dans les 3 derniers jours");
define("_DCATTHISWEEK","Nouveaux fichiers dans cette cat&eacute;gorie ajout&eacute;s cette semaine");
define("_DDATE1","Date (Anciens fichiers affich&eacute;s en premier)");
define("_DDATE2","Date (Nouveaux fichiers affich&eacute;s en premier)");
define("_DOWNLOADS","fichiers");
define("_DOWNLOADPROFILE","T&eacute;l&eacute;chargement - Profil");
define("_DOWNLOADRATINGDET","D&eacute;tails des &eacute;valuations");
define("_EDITTHISDOWNLOAD","Editer ce produit");
define("_DOWNLOADRATING","Evaluation des produits");
define("_DOWNLOADVOTE","Votez !");
define("_ONLYREGUSERSMODIFY","Seuls les utilisateurs enregistr&eacute;s peuvent sugg&eacute;rer des modifications pour les liens.  Veuillez <a href=\"user.php\">vous enregistrer ou vous connecter</a>.");
define("_REQUESTDOWNLOADMOD","Requ&ecirc;te de modification pour un produit");
define("_DOWNLOADID","ID du produit");
define("_DLETSDECIDE","Les contributions d'utilisateurs tels que vous aideront d'autres visiteurs &agrave; mieux choisir les fichiers &agrave; t&eacute;l&eacute;charger.");
define("_DRATENOTE4","Vous pouvez voir une liste des <a href=\"download.php?op=TopRated\">produits les mieux cot&eacute;s</a>.");

/*****************************************************/
/* Private Messages texts                            */
/*****************************************************/

define("_PRIVATEMESSAGES","Vos messages priv&eacute;s");
define("_CHECKALL","v&eacute;rifier tout");
define("_FROM","De");
define("_DATE","Date");
define("_DONTHAVEMESSAGES","Vous n'avez pas de message");
define("_NOTREAD","non lu");
define("_MSGSTATUS","Status du message");
define("_PRIVATEMESSAGE","Message priv&eacute;");
define("_INDEX","Index");
define("_POSTS","Envois");
define("_SENT","Envoy&eacute;");
define("_PREVIOUSMESSAGE","Message pr&eacute;c&eacute;dent");
define("_NEXTMESSAGE","Message suivant");
define("_PROFILE","Profil");
define("_ABOUTPOSTING","A propos de la messagerie");
define("_ALLREGCANPOST","Tous les utilisateurs enregistr&eacute;s peuvent poster des messages priv&eacute;s");
define("_TO","&agrave;");
define("_MESSAGEICON","Ic&ocirc;ne du message");
define("_MESSAGE","Message");
define("_HTML","HTML");
define("_PMON","On");
define("_PMOFF","Off");
define("_BBCODE","BBCode");
define("_WROTE","a &eacute;crit");
define("_OPTIONS","Options");
define("_HTMLDISSABLE","D&eacute;sactiver le HTML pour ce message");
define("_BBCODEDISSABLE","D&eacute;sactiver le <a href=\"bbcode_ref.php\" target=\"_blank\"><i>BBCode</i></a> pour ce message");
define("_SMILEDISSABLE","D&eacute;sactiver les <a href=\"bb_smilies.php\" target=\"_blank\"><i>&eacute;moticons</i></a> pour ce message");
define("_SHOWSIGNATURE","Montrer la signature");
define("_SIGNATUREMSG","Ceci peut &ecirc;tre modifi&eacute; ou ajout&eacute; pour votre profil");
define("_CANCELREPLY","Annuler la r&eacute;ponse");
define("_CANCELSEND","Annuler l'envoi");
define("_CLEAR","Effacer");
define("_SUBMIT","Soumettre");
define("_USERNOTINDB","L'utilisateur s&eacute;lectionn&eacute; n'existe pas dans la base de donn&eacute;es.");
define("_CHECKNAMEANDTRY","V&eacute;rifiez le nom et essayez &agrave; nouveau.");
define("_MSGPOSTED","Votre message a &eacute;t&eacute; post&eacute;.");
define("_RETURNTOPMSG","Vous pouvez cliquer ici pour recharger vos messages priv&eacute;s.");
define("_MSGDELETED","Vos messages ont &eacute;t&eacute; effac&eacute;s.");

/*****************************************************/
/* Web Links Messages texts                          */
/*****************************************************/

define("_ADDLINK","Ajouter un lien");
define("_NEW","Nouveaux");
define("_POPULAR","Populaires");
define("_TOPRATED","Mieux cot&eacute;s");
define("_RANDOM","Al&eacute;atoires");
define("_LINKSMAIN","Liens principaux");
define("_LINKCOMMENTS","Commentaires sur le lien");
define("_ADDITIONALDET","D&eacute;tails additionnels");
define("_EDITORREVIEW","Compte-rendu de l'&eacute;diteur");
define("_REPORTBROKEN","Signaler un lien mort");
define("_LINKSMAINCAT","Cat&eacute;gories principales des liens");
define("_AND","et");
define("_INDB","dans notre base de donn&eacute;e");
define("_ADDALINK","Ajouter un nouveau Lien");
define("_INSTRUCTIONS","Instructions");
define("_SUBMITONCE","Ne proposez qu'une seule fois un lien unique");
define("_POSTPENDING","Tous les liens post&eacute;s sont susceptibles d'&ecirc;tre v&eacute;rifi&eacute;s.");
define("_USERANDIP","L'identifiant utilisateur et le num&eacute;ro IP sont enregistr&eacute;s, n'abusez pas du syst&egrave;me svp.");
define("_PAGETITLE","Titre de la page");
define("_PAGEURL","URL de la page");
define("_YOUREMAIL","Votre Email");
define("_LDESCRIPTION","Description: (255 caract&egrave;res max)");
define("_ADDURL","Ajouter cet URL");
define("_LINKSNOTUSER1","Vous n'&ecirc;tes pas un utilisateur enregistr&eacute;, ou vous ne vous &ecirc;tes pas connect&eacute;.");
define("_LINKSNOTUSER2","Si vous &eacute;tiez enregistr&eacute;, vous pourriez ajouter des liens sur ce site.");
define("_LINKSNOTUSER3","Devenir un membre enregistr&eacute; est un processus simple et rapide.");
define("_LINKSNOTUSER4","Pourquoi demandons-nous un enregistrement pour l'acc&egrave;s &agrave; certaines options ?");
define("_LINKSNOTUSER5","De cette mani&egrave;re, nous pouvons vous offrir un contenu de qualit&eacute; &eacute;lev&eacute;,");
define("_LINKSNOTUSER6","chaque &eacute;l&eacute;ment est examin&eacute; individuellement et approuv&eacute; par notre &eacute;quipe.");
define("_LINKSNOTUSER7","Nous esp&eacute;rons vous offrir ainsi une information de valeur.");
define("_LINKSNOTUSER8","<a href=\"user.php\">Ouvrir un compte</a>");
define("_LINKALREADYEXT","ERREUR: Cet URL est d&eacute;j&agrave; pr&eacute;sent dans la base de donn&eacute;es!");
define("_LINKNOTITLE","ERREUR: Vous devez saisir un TITRE pour votre URL!");
define("_LINKNOURL","ERREUR: Vous devez saisir un URL pour votre URL!");
define("_LINKNODESC","ERREUR: Vous devez saisir une DESCRIPTION pour votre URL!");
define("_LINKRECEIVED","Nous avons re&ccedil;us votre proposition. Merci!");
define("_EMAILWHENADD","Vous recevrez un E-mail quand il sera approuv&eacute;.");
define("_CHECKFORIT","Vous n'avez pas entr&eacute; votre adresse Email.  Nous v&eacute;rifierons cependant votre lien prochainement.");
define("_NEWLINKS","Nouveaux liens");
define("_TOTALNEWLINKS","Total des nouveaux liens");
define("_LASTWEEK","La semaine derni&egrave;re");
define("_LAST30DAYS","Les 30 derniers jours");
define("_1WEEK","1 semaine");
define("_2WEEKS","2 semaines");
define("_30DAYS","30 jours");
define("_SHOW","Montrer");
define("_TOTALFORLAST","Total des nouveaux liens depuis");
define("_DAYS","jours");
define("_ADDEDON","Ajout&eacute; le");
define("_VOTE","Vote");
define("_VOTES","Votes");
define("_RATING","Evaluation");
define("_RATESITE","Evaluer ce site");
define("_DETAILS","D&eacute;tails");
define("_BESTRATED","Liens les mieux cot&eacute;s - Top");
define("_OF","de");
define("_TRATEDLINKS","total des liens &eacute;valu&eacute;s");
define("_TVOTESREQ","minimum de votes requis");
define("_SHOWTOP","Montrer le Top");
define("_MOSTPOPULAR","Les plus populaires - Top");
define("_OFALL","de tous les");
define("_LALSOAVAILABLE","Liens &eacute;galement disponibles dans");
define("_SUBCATEGORIES","sous-cat&eacute;gories");
define("_SORTLINKSBY","Trier les liens par");
define("_SITESSORTED","Sites actuellement class&eacute;s par");
define("_POPULARITY","Popularit&eacute;");
define("_SELECTPAGE","Selectionnez la page");
define("_MAIN","Principal");
define("_NEWTODAY","Nouveau aujourd'hui");
define("_NEWLAST3DAYS","Nouveau ces 3 derniers jours");
define("_NEWTHISWEEK","Nouveaux cette semaine");
define("_CATNEWTODAY","Nouveaux liens dans cette cat&eacute;gorie ajout&eacute;s aujourd'hui");
define("_CATLAST3DAYS","Nouveaux liens dans cette cat&eacute;gorie ajout&eacute;s ces 3 derniers jours");
define("_CATTHISWEEK","Nouveaux liens dans cette cat&eacute;gorie ajout&eacute;s cette semaine");
define("_POPULARITY1","Popularit&eacute; (du plus petit au plus grand nombre de hits)");
define("_POPULARITY2","Popularit&eacute; (du plus grand au plus petit nombre de hits)");
define("_TITLEAZ","Titre (de A &agrave; Z)");
define("_TITLEZA","Title (de Z &agrave; A)");
define("_DATE1","Date (Les liens les plus anciens affich&eacute;s en premier)");
define("_DATE2","Date (Les nouveaux liens affich&eacute;s en premier)");
define("_RATING1","Evaluation (du plus petit au plus grand score)");
define("_RATING2","Evaluation (du plus grand au plus petit score)");
define("_SEARCHRESULTS4","R&eacute;sultats de la recherche pour");
define("_USUBCATEGORIES","Sous-cat&eacute;gories");
define("_LINKS","Liens");
define("_TRY2SEARCH","Essayez de rechercher");
define("_INOTHERSENGINES","dans d'autres moteurs de recherche");
define("_EDITORIAL","Editorial");
define("_LINKPROFILE","Profil du lien");
define("_EDITORIALBY","Compte rendu par");
define("_NOEDITORIAL","Il n'y a pas de compte rendu disponible pour ce site.");
define("_VISITTHISSITE","Visitez ce site");
define("_RATETHISSITE","Evaluez ce site Web");
define("_ISTHISYOURSITE","S'agit-il de votre site Web ? ");
define("_ALLOWTORATE","Autorise les autres utilisateurs &agrave; voter depuis votre site Web !");
define("_LINKRATINGDET","D&eacute;tails de l'&eacute;valuation du lien");
define("_OVERALLRATING","Evaluation g&eacute;n&eacute;rale");
define("_TOTALOF","Total de");
define("_USER","Utilisateur");
define("_USERAVGRATING","Moyenne des &eacute;valuations de l'utilisateur");
define("_NUMRATINGS","# d'&eacute;valuations");
define("_EDITTHISLINK","Editer ce Lien");
define("_REGISTEREDUSERS","Utilisateurs enregistr&eacute;s");
define("_NUMBEROFRATINGS","Nombre d'&eacute;valuations");
define("_NOREGUSERSVOTES","Pas de votes d'utilisateurs enregistr&eacute;s");
define("_BREAKDOWNBYVAL","D&eacute;coupage des &eacute;valuations par valeur");
define("_LTOTALVOTES","vote(s) au total");
define("_LINKRATING","Evaluations des liens");
define("_HIGHRATING","Cote la plus haute");
define("_LOWRATING","Cote la plus basse");
define("_NUMOFCOMMENTS","Nombre de commentaires");
define("_WEIGHNOTE","* Note: Le poid que donne ce site aux &eacute;valuations des utilisateurs enregistr&eacute;s par rapport &agrave; celles des utilisateurs anonymes est de");
define("_NOUNREGUSERSVOTES","Pas de votes d'utilisateurs non-enregistr&eacute;s");
define("_WEIGHOUTNOTE","* Note: Le poid que donne ce site aux &eacute;valuations des utilisateurs enregistr&eacute;s par rapport &agrave; celles des utilisateurs ext&eacute;rieurs est de");
define("_NOOUTSIDEVOTES","Pas de votes d'&eacute;lecteurs ext&eacute;rieurs");
define("_OUTSIDEVOTERS","Electeurs ext&eacute;rieurs");
define("_UNREGISTEREDUSERS","Utilisateurs non-enregistr&eacute;s");
define("_PROMOTEYOURSITE","Faites la promo de votre site Web");
define("_PROMOTE01","Peut-&ecirc;tre serez-vous int&eacute;ress&eacute; par une de nos nombreuses options pour 'Evaluer un site' &agrave; distance.  Celles-ci vous permettent de placer une image (ou un formulaire d'&eacute;valuation) sur votre site pour augmenter le nombre de votes que votre site recevra.  Choisissez une des options pr&eacute;sent&eacute;es ci-dessous:");
define("_TEXTLINK","Lien textuel");
define("_PROMOTE02","Un des moyens de mener vers le formulaire d'&eacute;valuation est l'utilisation d'un lien textuel:");
define("_HTMLCODE1","Le code HTML &agrave; utiliser dans ce cas est::");
define("_THENUMBER","Le nombre");
define("_IDREFER","dans le source HTML r&eacute;f&eacute;rence l'ID de votre site dans la base de donn&eacute;es de $sitename.  Assurez vous que ce nombre est pr&eacute;sent.");
define("_BUTTONLINK","Lien 'bouton'");
define("_PROMOTE03","Si vous cherchez d'autres solutions qu'un simple lien textuel, vous choisirez peut-&ecirc;tre un lien par bouton:");
define("_RATEIT","Votez pour ce site !");
define("_HTMLCODE2","Le code source pour l'utilisation du bouton ci-dessus est:");
define("_REMOTEFORM","Formulaire d'&eacute;valuation &agrave; distance");
define("_PROMOTE04","Si vous tentez de tricher ici, nous enleverons votre lien. Ceci &eacute;tant dit, voici &agrave; quoi ressemble le formulaire d'&eacute;valuation &agrave; distance.");
define("_VOTE4THISSITE","Votez pour ce site !");
define("_LINKVOTE","Votez !");
define("_HTMLCODE3","L'utilisation de ce formulaire autorise vos visiteurs &agrave; voter pour votre site directement depuis vos pages Web, et l'&eacute;valuation sera enregistr&eacute;e ici.  Le formulaire ci-dessus est inactif, mais le code source suivant fonctionnera si vous le copiez et le collez sur une de vos pages Web.  Voici le code source:");
define("_PROMOTE05","Merci !  Et bonne chance pour l'&eacute;valuation de votre site !");
define("_STAFF","Equipe");
define("_THANKSBROKEN","Merci de votre aide pour maintenir l'int&eacute;grit&eacute; de ce r&eacute;pertoire.");
define("_SECURITYBROKEN","Pour des raisons de s&eacute;curit&eacute;, votre nom d'utilisateur et votre num&eacute;ro IP seront temporairement enregistr&eacute;s.");
define("_THANKSFORINFO","Merci pour cette information.");
define("_LOOKTOREQUEST","Nous examinerons votre requ&ecirc;te rapidement.");
define("_ONLYREGUSERSMODIFY","Seuls les utilisateurs enregistr&eacute;s peuvent sugg&eacute;rer des modifications pour les liens.  Veuillez <a href=\"user.php\">vous enregistrer ou vous connecter</a>.");
define("_REQUESTLINKMOD","Requ&ecirc;te de modification d'un lien");
define("_LINKID","ID du lien");
define("_SENDREQUEST","Envoyer votre requ&ecirc;te");
define("_THANKSTOTAKETIME","Merci de prendre le temps d'&eacute;valuer les sites sur");
define("_LETSDECIDE","Les contributions d'utilisateurs tels que vous aideront d'autres visiteurs &agrave; mieux choisir les liens sur lesquels cliquer.");
define("_WEAPPRECIATE","Nous appr&eacute;cions votre visite de");
define("_RETURNTO","Retour &agrave;");
define("_RATENOTE1","Ne votez pas pour le m&ecirc;me site plus d'une fois SVP.");
define("_RATENOTE2","L'&eacute;chelle est de 1 &agrave; 10, 1 &eacute;tant <I> faible </I> et 10 <I> excellent </I>.");
define("_RATENOTE3","Soyez objectif dans votre vote, si chacun re&ccedil;oit un 1 ou un 10, le syst&egrave;me d'&eacute;valuation n'est plus tr&egrave;s utile.");
define("_RATENOTE4","Vous pouvez voir une liste des <a href=\"links.php?op=TopRated\">sites les mieux cot&eacute;s</a>.");
define("_RATENOTE5","Ne votez pas pour votre propre site ou le site d'un concurrent.");
define("_YOUAREREGGED","Vous &ecirc;tes un utilisateur enregistr&eacute; et vous &ecirc;tes connct&eacute;.");
define("_FEELFREE2ADD","Votre commentaire &agrave; propos de ce site est le bienvenu.");
define("_YOUARENOTREGGED","Vous n'&ecirc;tes pas un utilisateur enregistr&eacute;, ou vous ne vous &ecirc;tes pas connect&eacute;.");
define("_IFYOUWEREREG","Si vous &eacute;tiez enregistr&eacute;, vous pourriez commenter ce site.");

/*****************************************************/
/* Messages System texts                             */
/*****************************************************/

define("_MVIEWADMIN","Visualisation: Administrateurs seulement");
define("_MVIEWUSERS","Visualisation: Utilisateurs enregistr&eacute;s seulement");
define("_MVIEWANON","Visualisation: Utilisateurs anonymes seulement");
define("_MVIEWALL","Visualisation: Tous les visiteurs");
define("_EXPIRELESSHOUR","Expiration: Moins d'une heure");
define("_EXPIREIN","Expiration dans");

/*****************************************************/
/* Administration Messages texts                     */
/*****************************************************/

define("_FILEMANAGER","Gestionnaire de Fichier");
define("_CURRENTDIR","Le r&eacute;pertoire actuel est");
define("_BACKTOROOT","Retour &agrave; la racine");
define("_REFRESH","Rafra&icirc;chir");
define("_ADMINID","ID Admin");
define("_ADMINLOGIN","Administration Syst&egrave;me: Login");
define("_FAQ","FAQ");
define("_DOWNLOAD","T&eacute;l&eacute;chargement");
define("_HEADLINES","Manchettes");
define("_LEFTBLOCKS","Blocs de Gauche");
define("_WEBLINKS","Liens Web");
define("_MAINBLOCK","Bloc Principal");
define("_EDITADMINS","Editer l'auteur");
define("_ADMINBLOCK","Bloc Admin");
define("_HTTPREFERERS","R&eacute;f&eacute;rants HTTP");
define("_PREFERENCES","Pr&eacute;f&eacute;rences");
define("_ADMPOLLS","Sondages");
define("_RIGHTBLOCKS","Blocs de Droite");
define("_SECTIONSMANAGER","Gestion des Rubriques");
define("_ADDSTORY","Ajouter l'article");
define("_AUTOARTICLES","Articles automatiques");
define("_EDITUSERS","Gestion des utilisateurs");
define("_ADMINMENU","Menu Administration");
define("_BANNERSADMIN","Administration des Banni&egrave;res");
define("_ONLINEMANUAL","Manuel en ligne");
define("_ADMINLOGOUT","Sortie");
define("_LAST","Derniers");
define("_GO","Ok");
define("_CURRENTPOLL","Sondage en cours");
define("_STORYID","ID article");

/*****************************************************/
/* Banners Administration texts                      */
/*****************************************************/

define("_ACTIVEBANNERS","Banni&egrave;res Actives");
define("_ACTIVEBANNERS2","Bannieres Actives");
define("_IMPRESSIONS","Impressions");
define("_IMPLEFT","Imp. Restantes");
define("_CLICKS","Clicks");
define("_CLICKSPERCENT","% Clicks");
define("_CLIENTNAME","Nom du client");
define("_UNLIMITED","Illimit&eacute;es");
define("_FINISHEDBANNERS","Banni&egrave;res P&eacute;rim&eacute;es");
define("_IMP","Imp.");
define("_DATESTARTED","Date de d&eacute;but");
define("_DATEENDED","Date de fin");
define("_ADVERTISINGCLIENTS","Annonceurs");
define("_CONTACTNAME","Nom du contact");
define("_CONTACTEMAIL","E-mail");
define("_ADDNEWBANNER","Ajouter une nouvelle banni&egrave;re");
define("_PURCHASEDIMPRESSIONS","Impressions achet&eacute;es");
define("_IMAGEURL","URL vers l'image");
define("_CLICKURL","URL du clic");
define("_ADDBANNER","Ajouter une banni&egrave;re");
define("_ADDCLIENT","Ajouter un nouveau client");
define("_CLIENTLOGIN","Login du client");
define("_CLIENTPASSWD","Mot de passe du client");
define("_ADDCLIENT2","Ajouter un client");
define("_BANNERSNOTACTIVE","La variable Banni&egrave;re dans config.php est &agrave; 0, ce qui signifie que vous ne pourrez voir vos banni&egrave;res que lorsque vous les aurez activ&eacute;es.");
define("_TOACTIVATE","Pour ce faire, changez cette valeur dans les <a href=\"admin.php?op=Configure#banners\">pr&eacute;f&eacute;rences</a>.");
define("_IMPORTANTNOTE","Note importante !");
define("_DELETEBANNER","D&eacute;truire la banni&egrave;re");
define("_SURETODELBANNER","Etes-vous s&ucirc;r de vouloir d&eacute;truire cette Banni&egrave;re ?");
define("_EDITBANNER","Edition de la banni&egrave;re");
define("_ADDIMPRESSIONS","Ajouter plus d'impressions");
define("_PURCHASED","Achet&eacute;es");
define("_MADE","Accomplies");
define("_DELETECLIENT","Supprimer Client Publicitaire");
define("_SURETODELCLIENT","Vous &ecirc;tes sur le point d'enlever un client et toutes ses banni&egrave;res !!!");
define("_CLIENTWITHOUTBANNERS","Ce client n'a pas de banni&egrave;re active pour le moment.");
define("_DELCLIENTHASBANNERS","Ce client a les BANNI&Egrave;RES suivantes activ&eacute;es et en fonction.");
define("_EDITCLIENT","Edition du client annonceur");

/*****************************************************/
/* Comments Administration texts                     */
/*****************************************************/

define("_REMOVECOMMENTS","Effacer les commentaires");
define("_SURETODELCOMMENTS","Etes-vous s&ucirc;r de vouloir supprimer le commentaire s&eacute;lectionn&eacute; et toutes les r&eacute;ponses ?");

/*****************************************************/
/* Blocks Administration texts                       */
/*****************************************************/

define("_BLOCKSADMIN","Administration des blocs");
define("_BLOCKS","Blocs");
define("_FIXEDBLOCKS","Blocs syst&egrave;me fixes");
define("_TITLE","Titre");
define("_POSITION","Position");
define("_WEIGHT","Poid");
define("_STATUS","Status");
define("_LEFTBLOCK","Bloc de gauche");
define("_LEFT","Gauche");
define("_RIGHTBLOCK","Bloc de droite");
define("_RIGHT","Droite");
define("_ACTIVE","Actif");
define("_DEACTIVATE","D&eacute;sactiver");
define("_INACTIVE","Inactif");
define("_ACTIVATE","Activer");
define("_USERBLOCKS","Blocs d&eacute;finis par l'utilisateur");
define("_TYPE","Type");
define("_ADDNEWBLOCK","Ajouter un nouveau bloc");
define("_RSSFILE","URL du fichier RSS/RDF");
define("_ONLYHEADLINES","(Seulement pour les manchettes)");
define("_CONTENT","Contenu");
define("_ACTIVATE2","Activer ?");
define("_REFRESHTIME","D&eacute;lai de rafra&icirc;chissement");
define("_HOUR","Heure");
define("_HOURS","heures");
define("_CREATEBLOCK","Cr&eacute;er un bloc");
define("_EDITBLOCK","Editer un bloc");
define("_BLOCK","Bloc");
define("_SAVEBLOCK","Sauvegarder le bloc");
define("_EDITFIXEDBLOCK","Editer un bloc fixe");
define("_BLOCKACTIVATION","Activation du bloc");
define("_BLOCKPREVIEW","Pr&eacute;visualisation du bloc");
define("_WANT2ACTIVATE","Voulez-vous activer ce bloc ?");
define("_ARESUREDELBLOCK","Etes-vous s&ucirc;r de vouloir enlever ce bloc ?");
define("_RSSFAIL","Il y a un probl&egrave;me avec l'URL du fichier RSS");
define("_RSSTRYAGAIN","Veuillez v&eacute;rifier l'URL et le nom du fichier RSS, et essayez &agrave; nouveau.");
define("_RSSPROBLEM","La manchette de ce site n'est pas disponible pour le moment.");
define("_RSSCONTENT","(Contenu RSS/RDF)");
define("_IFRSSWARNING","Si vous entrez un URL, le contenu que vous avez &eacute;crit ne sera pas affich&eacute; !");
define("_SELECTLANGUAGE","Selectionnez la langue");
define("_SELECTGUILANG","Selectionnez la langue de l'interface:");
define("_BLOCKUP","Remonter le bloc");
define("_BLOCKDOWN","Descendre le bloc");
define("_SETUPHEADLINES","(Pour obtenir de nouvelles manchettes, s&eacute;lectionnez un site dans la liste ou choisissez Autre et entrez l'URL)");
define("_HEADLINESADMIN","Administration des manchettes");
define("_ADDHEADLINE","Ajouter une Manchette");
define("_EDITHEADLINE","Editer les manchettes");
define("_SURE2DELHEADLINE","ATTENTION: Etes-vous s&ucirc;r de vouloir enlever cette manchette?");
define("_CUSTOM","Autre");

/*****************************************************/
/* FAQ Administration texts                          */
/*****************************************************/

define("_FAQADMIN","Administration FAQ");
define("_ACTIVEFAQS","FAQs actives");
define("_ADDCATEGORY","Ajouter une nouvelle cat&eacute;gorie");
define("_QUESTIONS","Questions et r&eacute;ponses");
define("_ADDQUESTION","Ajouter une nouvelle question");
define("_QUESTION","Question");
define("_ANSWER","R&eacute;ponse");
define("_EDITCATEGORY","Editer la cat&eacute;gorie");
define("_EDITQUESTIONS","Editer les questions et r&eacute;ponses");
define("_FAQDELWARNING","ATTENTION: Etes-vous s&ucirc;r de vouloir effacer cet Faq et tout son contenu ?");
define("_QUESTIONDEL","ATTENTION: Etes-vous s&ucirc;r de vouloir effacer cette question?");

/*****************************************************/
/* Author's Administration texts                     */
/*****************************************************/

define("_AUTHORSADMIN","Adminitration des auteurs");
define("_MODIFYINFO","Modifier l'Information");
define("_DELAUTHOR","Enlever un auteur");
define("_ADDAUTHOR","Ajouter un nouvel administrateur");
define("_PERMISSIONS","Permissions");
define("_TOPICS","Sujets");
define("_USERS","Utilisateurs");
define("_SURVEYS","Sondages");
define("_SECTIONS","Rubriques");
define("_SUPERUSER","Super Utilisateur");
define("_SUPERWARNING","ATTENTION: Si Super Utilisateur est coch&eacute;, l'utilisateur aura tous les acc&egrave;s ouverts !");
define("_ADDAUTHOR2","Ajouter un Auteur ");
define("_RETYPEPASSWD","Retapez votre mot de Passe");
define("_FORCHANGES","(Pour les changements seulement)");
define("_COMPLETEFIELDS","Vous devez remplir tous les Champs");
define("_CREATIONERROR","Erreur dans la cr&eacute;ation d'un compte auteur");
define("_AUTHORDELSURE","Etes-vous s&ucirc;r de vouloir supprimer");
define("_AUTHORDEL","Enlever un auteur");
define("_REQUIREDNOCHANGE","(requis, ne peut pas &ecirc;tre chang&eacute; plus tard)");
define("_PUBLISHEDSTORIES","Cet administrateur a publi&eacute; des articles");
define("_SELECTNEWADMIN","Choisissez un nouvel administrateur &agrave; qui les assigner");
define("_GODNOTDEL","*(Le compte DIEU ne peut pas &ecirc;tre effac&eacute;)");
define("_MAINACCOUNT","Admin Dieu*");

/*****************************************************/
/* Articles/Stories Administration texts             */
/*****************************************************/

define("_ARTICLEADMIN","Administration des articles/nouvelles");
define("_ADDARTICLE","Ajouter un nouvel article");
define("_STORYTEXT","Texte de l'article");
define("_EXTENDEDTEXT","Suite du Texte");
define("_ARESUREURL","(Etes-vous s&ucirc;r d'inclure un URL ? Avez-vous verifi&eacute; l'orthographe ?)");
define("_PUBLISHINHOME","Publier sur la page principale?");
define("_ONLYIFCATSELECTED","Ne fonctionne que si la cat&eacute;gorie <i>Articles</i> n'est pas s&eacute;lectionn&eacute;e.");
define("_ADD","Ajouter");
define("_PROGRAMSTORY","Voulez-vous programmer cet article ?");
define("_NOWIS","Aujourd'hui:");
define("_DAY","Jour");
define("_UMONTH","Mois");
define("_YEAR","Ann&eacute;e");
define("_PREVIEWSTORY","Prévisualisation de l'article");
define("_POSTSTORY","Poster l'article");
define("_AUTOMATEDARTICLES","Articles programm&eacute;s");
define("_NOAUTOARTICLES","Il n'y a pas d'articles programm&eacute;s.");
define("_REMOVESTORY","Etes-vous s&ucirc;r de vouloir effacer l'article ID #");
define("_ANDCOMMENTS","et tous ses commentaires ?");
define("_CATEGORIESADMIN","Administration des cat&eacute;gories");
define("_CATEGORYADD","Ajouter une nouvelle cat&eacute;gorie");
define("_CATNAME","Nom de la cat&eacute;gorie");
define("_NOARTCATEDIT","Vous ne pouvez pas &eacute;diter une cat&eacute;gorie <i>Articles</i>");
define("_ASELECTCATEGORY","Selectionnez une cat&eacute;gorie");
define("_CATEGORYNAME","Nom de la cat&eacute;gorie");
define("_DELETECATEGORY","Effacer une cat&eacute;gorie");
define("_SELECTCATDEL","Selectionnez une cat&eacute;gorie &agrave; effacer");
define("_CATDELETED","Cat&eacute;gorie effac&eacute;e !");
define("_WARNING","Attention");
define("_THECATEGORY","La cat&eacute;gorie");
define("_HAS","contient");
define("_STORIESINSIDE","articles");
define("_DELCATWARNING1","Vous pouvez supprimer cette cat&eacute;gorie et TOUS ses articles et commentaires");
define("_DELCATWARNING2","ou d&eacute;placer TOUS les articles dans une nouvelle cat&eacute;gorie.");
define("_DELCATWARNING3","Que voulez-vous faire ?");
define("_YESDEL","Oui !  Effacer TOUT!");
define("_NOMOVE","Non !  D&eacute;placer les articles !");
define("_MOVESTORIES","D&eacute;placer les articles dans une autre cat&eacute;gorie");
define("_ALLSTORIES","TOUT les articles de");
define("_WILLBEMOVED","seront d&eacute;plac&eacute;s.");
define("_SELECTNEWCAT","Veuillez choisir une nouvelle cat&eacute;gorie");
define("_MOVEDONE","F&eacute;licitation !  Le d&eacute;plavement est r&eacute;ussi !");
define("_CATEXISTS","Cette cat&eacute;gorie existe d&eacute;j&agrave; !");
define("_CATSAVED","Cat&eacute;gorie sauvegard&eacute;e !");
define("_GOTOADMIN","Aller dans la partie Admin");
define("_CATADDED","Nouvelle cat&eacute;gorie ajout&eacute;e !");
define("_AUTOSTORYEDIT","Editer l'article automatique");
define("_NOTES","Notes");
define("_CHNGPROGRAMSTORY","Entrez une nouvelle date pour cet article:");
define("_SUBMISSIONSADMIN","Administration des propositions d'article");
define("_DELETESTORY","Effacer l'article");
define("_EDITARTICLE","Editer l'article");
define("_NOSUBMISSIONS","Pas de nouvelles propositionss");
define("_NEWSUBMISSIONS","Nouveaux articles propos&eacute;s");
define("_NOFUNCTIONS","---------");
define("_NOTAUTHORIZED1","Vous n'&ecirc;tes pas autoris&eacute; &agrave; modifier cet article !");
define("_NOTAUTHORIZED2","Vous ne pouvez pas &eacute;diter ou supprimer les articles que vous n'avez pas publi&eacute;s");

/*****************************************************/
/* HTTP Referers Administration texts                */
/*****************************************************/

define("_WHOLINKS","Qui place des liens vers notre site ?");
define("_DELETEREFERERS","Effacer les r&eacute;f&eacute;rants");

/*****************************************************/
/* Polls/Surveys Administration texts                */
/*****************************************************/

define("_POLLSADMIN","Administration des sondages");
define("_CREATEPOLL","Cr&eacute;er un nouveau sondage");
define("_DELETEPOLLS","Supprimer des sondages");
define("_POLLTITLE","Titre du sondage");
define("_POLLEACHFIELD","S.V.P. entrez une option disponible dans un seul champ");
define("_CREATEPOLLBUT","Cr&eacute;er un sondage");
define("_REMOVEEXISTING","Supprimer un sondage existant");
define("_POLLDELWARNING","ATTENTION: Le sondage choisi vas &ecirc;tre IMMEDIATEMENT supprim&eacute; de la base de donn&eacute;e!");
define("_CHOOSEPOLL","Choisissez un sondage dans la liste ci-dessous:");

/*****************************************************/
/* Topics Manager Administration texts               */
/*****************************************************/

define("_TOPICSMANAGER","Affectation des Sujets");
define("_CURRENTTOPICS","Sujets actifs");
define("_CLICK2EDIT","Cliquez sur le sujet &agrave; &eacute;diter");
define("_ADDATOPIC","Ajouter un nouveau sujet");
define("_TOPICNAME","Nom du sujet");
define("_TOPICNAME1","(Nom sans espaces - 20 caract&egrave;res Max.)");
define("_TOPICNAME2","(par exemple: jeuxetloisirs)");
define("_TOPICTEXT","Texte du sujet");
define("_TOPICTEXT1","(Description ou nom complet du sujet - max: 40 caract&egrave;res)");
define("_TOPICTEXT2","(par exemple: Jeux et Loisirs)");
define("_TOPICIMAGE","Image du sujet");
define("_TOPICIMAGE1","nom de l'image + extension plac&eacute; dans");
define("_TOPICIMAGE2","(par exemple: jeux.gif)");
define("_ADDTOPIC","Ajouter un sujet");
define("_EDITTOPIC","Editer le sujet");
define("_ADDRELATED","Ajouter des liens en relation");
define("_ACTIVERELATEDLINKS","Liens relatifs activ&eacute;s");
define("_SITENAME","Nom du Site");
define("_NORELATED","Il n'y a pas de liens relatifs pour ce sujet");
define("_EDITRELATED","Editer un Lien Relatif");
define("_DELETETOPIC","Supprimer le sujet");
define("_TOPICDELSURE","Etes-vous s&ucirc;r de vouloir enlever ce sujet ?");
define("_TOPICDELSURE1","Ceci supprimera tous les articles et leurs commentaires !");

/*****************************************************/
/* User's Administration texts                       */
/*****************************************************/

define("_USERADMIN","Administration des utilisateurs");
define("_EDITUSER","Edition Utilisateur");
define("_MODIFY","Modifier");
define("_ADDUSER","Ajouter un nouvel utilisateur");
define("_FAKEEMAIL","E-mail factice");
define("_ALLOWUSERS","Autoriser les autres utilisateurs &agrave; voir mon adresse Email");
define("_ADDUSERBUT","Ajouter un utilisateur");
define("_USERUPDATE","Mise-&agrave;-jour utilisateur");
define("_USERID","ID Utilisateur");
define("_USERNOEXIST","L'utilisateur n'existe pas !");
define("_PASSWDNOMATCH","D&eacute;sol&eacute;, les mots de passe ne correspondent pas.  Retournez &agrave; la page pr&eacute;c&eacute;dente et essayez &agrave; nouveau.");
define("_DELETEUSER","Enlever un utilisateur");
define("_SURE2DELETE","Etes-vous s&ucirc;r de vouloir enlever un utilisateur");
define("_NEEDTOCOMPLETE","Vous devez compl&eacute;ter tous les champs requis");

/*****************************************************/
/* Settings Administration texts                     */
/*****************************************************/

define("_SITECONFIG","Configuration du site Web");
define("_GENSITEINFO","Infos G&eacute;n&eacute;rales sur le Site");
define("_SITEURL","URL du site");
define("_SITELOGO","Logo du site");
define("_SITESLOGAN","Slogan du site");
define("_ADMINEMAIL","Email de l'administrateur");
define("_ITEMSTOP","Nombre d'&eacute;l&eacute;ments sur la page Top");
define("_STORIESHOME","Nombre d'articles sur la page d'accueil");
define("_OLDSTORIES","Nombre d'articles dans la bo&icirc;te des Articles Pr&eacute;c&eacute;dents");
define("_ACTULTRAMODE","Activer l'Ultramode?");
define("_DEFAULTTHEME","Th&egrave;me par d&eacute;faut pour votre site");
define("_SELLANGUAGE","Selectionnez la langue de votre site");
define("_LOCALEFORMAT","Format local pour la date et l'heure");
define("_BANNERSOPT","Options pour les banni&egrave;res");
define("_STARTDATE","Date de mise en ligne du site");
define("_ACTBANNERS","Activer les banni&egrave;res sur votre site?");
define("_YOURIP","Votre IP pour ne pas compter les hits");
define("_FOOTERMSG","Messages de bas de page");
define("_FOOTERLINE1","Ligne de pied 1");
define("_FOOTERLINE2","Ligne de pied 2");
define("_FOOTERLINE3","Ligne de pied 3");
define("_FOOTERLINE4","Ligne de pied 4");
define("_BACKENDCONF","Configuration syndication");
define("_BACKENDTITLE","Syndication - Titre");
define("_BACKENDLANG","Syndication - Langue");
define("_WEBLINKSCONF","Configuration par d&eacute;faut des liens Web");
define("_LINKSPAGE","Liens par page");
define("_TOBEPOPULAR","Nombre de hits pour &ecirc;tre Populaire");
define("_LINKSASNEW","Nombre de liens Nouveaux");
define("_LINKSASBEST","Nombre de liens Meilleurs");
define("_LINKSINRES","Nombre de liens dans le r&eacute;sultat d'une recherche");
define("_ANONPOSTLINKS","Autoriser les utilisateurs anonymes &agrave; proposer de nouveaux liens ?");
define("_MAIL2ADMIN","Envoyer les nouveaux articles par e-mail &agrave; l'administrateur");
define("_NOTIFYSUBMISSION","Notifier les suggestions par e-mail?");
define("_EMAIL2SENDMSG","Adresse Email o&ugrave; envoyer le message");
define("_EMAILSUBJECT","Objet du message");
define("_EMAILMSG","Message");
define("_EMAILFROM","Compte Email (From)");
define("_COMMENTSMOD","Mod&eacute;ration des commentaires");
define("_MODTYPE","Type de mod&eacute;ration");
define("_MODADMIN","Mod&eacute;ration par l'administrateur");
define("_MODUSERS","Mod&eacute;ration par les utilisateurs");
define("_NOMOD","Pas de Mod&eacute;ration");
define("_COMMENTSOPT","Options pour les commentaires");
define("_COMMENTSLIMIT","Limite en octets pour les commentaires");
define("_ANONYMOUSNAME","Nom par d&eacute;faut pour les anonymes");
define("_SURVEYSCONF","Options pour les sondages");
define("_SCALEBAR","Echelle des barres de r&eacute;sultat");
define("_ALLOWTWICE","Autoriser les utilisateurs &agrave; voter deux fois?");
define("_GRAPHICOPT","Options graphiques");
define("_TOPICSPATH","Chemin vers les images Sujets");
define("_USERPATH","Chemin vers les images du Menu Utilisateur");
define("_ADMINPATH","Chemin vers les images du Menu Administrateur");
define("_ADMINGRAPHIC","Utiliser des images dans le menu Administration?");
define("_SITEFONT","Police de caract&egrave;re du site");
define("_MISCOPT","Options diverses");
define("_ARTINADMIN","Nombre d'articles sur la page Admin");
define("_PASSWDLEN","Taille minimale pour le mot de passe des utilisateurs");
define("_MAXREF","Combien de r&eacute;f&eacute;rants voulez-vous garder au maximum?");
define("_COMMENTSPOLLS","Activer les commentaires pour les Sondages?");
define("_EPHEMACT","Activer le syst&egrave;me d'&eacute;ph&eacute;m&eacute;rides?");
define("_ALLOWANONPOST","Accepter les envois anonymes?");
define("_ACTIVATEHTTPREF","Activer le tra&ccedil;age des r&eacute;f&eacute;rants HTTP?");

/*****************************************************/
/* Sections Administration texts                     */
/*****************************************************/

define("_SECTIONSADMIN","Administration des rubriques");
define("_ACTIVESECTIONS","Rubriques Actives");
define("_CLICK2EDITSEC","(Cliquez pour &eacute;diter)");
define("_ADDSECARTICLE","Ajouter un nouvel article dans les rubriques");
define("_EDITARTID","Editer l'article ID");
define("_ADDSECTION","Ajouter une nouvelle Rubrique");
define("_SECTIONNAME","Nom de la rubrique");
define("_SECTIONIMG","Image de la rubrique");
define("_SECIMGEXAMPLE","(sera plac&eacute;e dans le r&eacute;pertoire /images/sections/ . Exemple: opinion.gif)");
define("_ADDSECTIONBUT","Ajouter une rubrique");
define("_SELSECTION","Selectionnez une rubrique");
define("_SECTIONHAS","Cette rubrique contient");
define("_ARTICLESATTACH","articles");
define("_40CHARSMAX","(40 caract&egrave;res max.)");
define("_EDITSECTION","Editer une rubrique");
define("_DELSECWARNING","Etes-vous s&ucirc;r de vouloir enlever cette rubrique?");
define("_DELSECWARNING1","Ceci detruira tous les articles qu'elle contient!");
define("_DELARTWARNING","Etes-vous s&ucirc;r de vouloir effacer cet article?");
define("_DELSECTION","Effacer une rubrique");
define("_DELARTICLE","Effacer l'article");

/*****************************************************/
/* Ephemerids Administration texts                   */
/*****************************************************/

define("_EPHEMADMIN","Administration des &eacute;ph&eacute;m&eacute;rides");
define("_ADDEPHEM","Ajouter une nouvelle &eacute;ph&eacute;m&eacute;ride");
define("_EPHEMDESC","Description de l'&eacute;ph&eacute;m&eacute;ride");
define("_EPHEMMAINT","Maintenance de l'&eacute;ph&eacute;m&eacute;ride (Edition/Suppression):");
define("_EPHEMEDIT","Editer les &eacute;ph&eacute;m&eacute;rides");

/*****************************************************/
/* Reviews Administration texts                      */
/*****************************************************/

define("_REVADMIN","Administration des comptes rendus");
define("_REVTITLE","Titre de la page des comptes rendus");
define("_REVDESC","Description de la page des comptes rendus");
define("_REVWAITING","Comptes rendus en attente de validation");
define("_REVIMGINFO","Conservez votre image 150*150 dans images/reviews");
define("_TEXT","Texte");
define("_IMAGE","Image");
define("_NOREVIEW2ADD","Pas de compte rendu &agrave; ajouter");
define("_ADDREVIEW","Ajouter un compte rendu");
define("_CLICK2ADDREVIEW","Cliquez ici pour &eacute;crire un compte rendu");
define("_DELMODREVIEW","Supprimer / Modifier un compte rendu");
define("_MODREVINFO","Vous pouvez modifier/supprimer un compte rendu en parcourant simplement <a href=\"reviews.php\">reviews.php</a> en tant qu'administrateur.");

/*****************************************************/
/* File Manager Administration texts                 */
/*****************************************************/

define("_SIZE","Taille");
define("_MODIFIED","Modifi&eacute;");
define("_PARENTDIR","R&eacute;pertoire parent");
define("_CHANGEDIR","Changer le r&eacute;pertoire de travail pour");
define("_MOVRENCP","D&eacute;placer, renommer ou copier");
define("_TOUCH","Toucher");
define("_AUDIO","Audio");
define("_WEBPROGRAM","Programme Web");
define("_APACHESET","R&eacute;glages de s&eacute;curit&eacute; du serveur Web Apache");
define("_WEBPAGE","Page Web");
define("_UNKOWNFT","Type de fichier inconnu");
define("_UPLOADFILE","T&eacute;l&eacute;verser un fichier");
define("_CREATEDIR","Cr&eacute;er un r&eacute;pertoire");
define("_CREATEFILE","Cr&eacute;er un fichier");
define("_HTMLTEMP","(gabarit HTML)");
define("_UPLOADED","T&eacute;l&eacute;vers&eacute;");
define("_LISTINGDIR","Contenu du r&eacute;pertoire");
define("_BROWSE","Parcourir");
define("_LISTDIR","Contenu du r&eacute;pertoire");
define("_CHANGED2ROOT","Chang&eacute; pour le r&eacute;pertoire racine");
define("_DISPHP","Affichage de l'environnement PHP");
define("_CHANGEDDIR","r&eacute;pertoire chang&eacute; pour");
define("_TOUCHED","Touch&eacute;");
define("_DELETED","Effac&eacute;");
define("_FMSURE2DEL","Etes-vous s&ucirc;r de vouloir SUPPRIMER");
define("_DESTFILEEXT","Le fichier de destination existe d&eacute;j&agrave;. Op&eacute;ration annul&eacute;e.");
define("_COPIED","Copi&eacute;");
define("_MOVREN","D&eacute;plac&eacute;/Renomm&eacute;");
define("_MOVRENAMING","En cours de d&eacute;placement/renommage ou de copie");
define("_COPY","Copie");
define("_MOVREN2","D&eacute;placer/Renommer");
define("_EDITED","Edit&eacute;");
define("_EDITING","En &eacute;dition");
define("_DISPLAYING","Affichage");
define("_THEDIR","Le r&eacute;pertoire");
define("_ALREADYEXT","existe d&eacute;j&agrave;.");
define("_DIRCREATED","R&eacute;pertoire cr&eacute;&eacute;");
define("_CREATED","cr&eacute;&eacute;");
define("_CREATING","Creation");
define("_UNTITLED","sansnom");

/*****************************************************/
/* Downloads Administration texts                    */
/*****************************************************/

define("_DOWNLOADSINDB","Fichiers t&eacute;l&eacute;chargeables");
define("_DOWNLOADSWAITINGVAL","Fichiers en attente de validation");
define("_CLEANDOWNLOADSDB","Nettoyage des &eacute;valuations");
define("_BROKENDOWNLOADSREP","Rapports de probl&egrave;mes de t&eacute;l&eacute;chargement");
define("_DOWNLOADMODREQUEST","Requ&ecirc;tes de modifications pour un fichier");
define("_ADDNEWDOWNLOAD","Ajouter un nouveau fichier");
define("_MODDOWNLOAD","Modifier les donn&eacute;es d'un produit");
define("_WEBDOWNLOADSADMIN","Administration T&eacute;l&eacute;chargement");
define("_DNOREPORTEDBROKEN","Pas de fichiers introuvables signal&eacute;s.");
define("_DUSERREPBROKEN","Fichiers introuvables signal&eacute;s par les membres");
define("_DIGNOREINFO","Ignorer (Efface toutes les <b><i>requ&ecirc;tes</i></b> pour un fichier particulier)");
define("_DDELETEINFO","Supprimer (Enl&egrave;ve tous les <b><i>fichiers perdus</i></b> et les <b><i>requ&ecirc;tes</i></b> pour ce fichier)");
define("_DOWNLOAD","T&eacute;l&eacute;chargement");
define("_DOWNLOADOWNER","Propri&eacute;taire du fichier");
define("_DUSERMODREQUEST","Requ&ecirc;tes d'utilisateurs pour modifier un fichier");
define("_DDELCATWARNING","ATTENTION: Etes vous s&ucirc;r de vouloir effacer cette cat&eacute;gorie et TOUS ses fichiers ?");
define("_DOWNLOADVALIDATION","Validation d'un fichier");
define("_CHECKALLDOWNLOADS","V&eacute;rifier TOUS les fichiers");
define("_VALIDATEDOWNLOADS","Valider les fichiers");
define("_NEWDOWNLOADADDED","Nouveau fichier ajout&eacute; &agrave; la base de donn&eacute;es");
define("_YOURDOWNLOADAT","Votre fichier sur");
define("_DWEAPPROVED","Votre fichier a &eacute;t&eacute; approuv&eacute; pour notre base de donn&eacute;es.");

/*****************************************************/
/* Web Links Administration texts                    */
/*****************************************************/

define("_LINKSINDB","Liens dans notre base de donn&eacute;es");
define("_LINKSWAITINGVAL","Liens en attente de Validation");
define("_SUBMITTER","Propos&eacute; par");
define("_NONE","Aucun");
define("_VISIT","Visite");
define("_CLEANLINKSDB","Nettoyage de la BD des liens");
define("_BROKENLINKSREP","Liens morts signal&eacute;s");
define("_LINKMODREQUEST","Requ&ecirc;te de modification d'un lien");
define("_ADDMAINCATEGORY","Ajouter une Cat&eacute;gorie Principale");
define("_ADDSUBCATEGORY","Ajouter une Sous-Cat&eacute;gorie");
define("_IN","Dans");
define("_ADDNEWLINK","Ajouter un nouveau Lien");
define("_DESCRIPTION255","Description: (255 caract&egrave;res max)");
define("_MODCATEGORY","Modifier une cat&eacute;gorie");
define("_MODLINK","Modifier un lien");
define("_WEBLINKSADMIN","Administration des liens Web");
define("_ADDEDITORIAL","Ajouter un &eacute;ditorial");
define("_EDITORIALTITLE","Titre de l'&eacute;ditorial");
define("_EDITORIALTEXT","Edito");
define("_DATEWRITTEN","Date de r&eacute;daction");
define("_NOREPORTEDBROKEN","Pas de lien mort signal&eacute;.");
define("_USERREPBROKEN","Liens morts signal&eacute;s par les utilisateurs");
define("_IGNOREINFO","Ignorer (Efface toutes <b><i>les requ&ecirc;tes</i></b> pour un lien donn&eacute;)");
define("_DELETEINFO","Effacer (Efface <b><i>un lien mort</i></b> et <b><i>les requ&ecirc;tes</i></b> pour ce lien)");
define("_LINK","Lien");
define("_LINKOWNER","Propri&eacute;taire du lien");
define("_IGNORE","Ignorer");
define("_USERMODREQUEST","Requ&ecirc;tes de modifications de lien des utilisateurs");
define("_ORIGINAL","Original");
define("_PROPOSED","Propos&eacute;");
define("_NOMODREQUESTS","Il n'y a pas de requ&ecirc;te de modification pour le moment");
define("_SUBCATEGORY","Sous-cat&eacute;gorie");
define("_OWNER","Propri&eacute;taire");
define("_ACCEPT","Accepter");
define("_DELCATWARNING","ATTENTION: Etes-vous s&ucirc;r de vouloir supprimer cette Cat&eacute;gorie et tous ses Liens ?");
define("_ERRORTHECATEGORY","ERREUR: La Cat&eacute;gorie");
define("_ALREADYEXIST","existe d&eacute;j&agrave; !");
define("_ERRORTHESUBCATEGORY","ERREUR: La sous-cat&eacute;gorie");
define("_EDITORIALADDED","Editorial ajout&eacute; &agrave; la base de donn&eacute;es");
define("_EDITORIALMODIFIED","Editorial modifi&eacute;");
define("_EDITORIALREMOVED","Editorial enlev&eacute; de la base de donn&eacute;es");
define("_LINKVALIDATION","Validation des liens");
define("_CHECKALLLINKS","V&eacute;rifier TOUS les liens");
define("_CHECKCATEGORIES","V&eacute;rifier les cat&eacute;gories");
define("_INCLUDESUBCATEGORIES","(inclus les sous-cat&eacute;gories)");
define("_CHECKSUBCATEGORIES","V&eacute;rifier les sous-cat&eacute;gories");
define("_VALIDATELINKS","Valider les liens");
define("_FAILED","Echec !");
define("_BEPATIENT","(soyez patient)");
define("_VALIDATINGCAT","Valider une cat&eacute;gorie (et toutes les sous-cat&eacute;gories)");
define("_VALIDATINGSUBCAT","Validation de la sous-cat&eacute;gorie");
define("_ERRORURLEXIST","ERREUR: Cet URL est d&eacute;j&agrave; pr&eacute;sent dans la base de donn&eacute;es!");
define("_ERRORNOTITLE","ERREUR: Vous devez saisir un TITRE pour votre URL!");
define("_ERRORNOURL","ERREUR: Vous devez saisir un URL pour votre URL!");
define("_ERRORNODESCRIPTION","ERREUR: Vous devez saisir une DESCRIPTION pour votre URL!");
define("_NEWLINKADDED","Nouveau lien ajout&eacute; dans la base de donn&eacute;e");
define("_YOURLINKAT","Votre lien vers");
define("_WEAPPROVED","Nous avons approuv&eacute; votre suggestion pour notre moteur de recherche.");
define("_YOUCANBROWSEUS","Vous pouvez parcourir notre moteur de recherche sur:");
define("_THANKS4YOURSUBMISSION","Merci pour votre suggestion !");
define("_TEAM","Equipe.");

/*****************************************************/
/* Messages System texts                             */
/*****************************************************/

define("_MESSAGES","Messages");
define("_MESSAGESADMIN","Administration des messages");
define("_MESSAGETITLE","Titre");
define("_MESSAGECONTENT","Contenu");
define("_EXPIRATION","Expiration");
define("_VIEWPRIV","Qui peut le voir ?");
define("_MVADMIN","Les administrateurs seulement");
define("_MVUSERS","Les utilisateurs enregistr&eacute;s seulement");
define("_MVANON","Les utilisateurs anonymes seulement");
define("_MVALL","Tous les visiteurs");
define("_CHANGEDATE","Changer la date de d&eacute;but &agrave; aujourd'hui ?");
define("_IFYOUACTIVE","(Si vous activez ce message maintenant, la date de d&eacute;but sera aujourd'hui)");

/*****************************************************/
/* Added on PHP-Nuke 5.1                             */
/*****************************************************/

define("_FILENAME","Filename");
define("_FILEINCLUDE","(Select a custom Block to be included. All other fields will be ignored)");
define("_BLOCKPROBLEM","<center>There is a problem right now with this block.</center>");
define("_BLOCKFILE","(Block File)");
define("_EDITPOLL","Edit Polls");
define("_CHOOSEPOLLEDIT","Choose the Poll you want to edit:");
define("_BLOCKPROBLEM2","<center>There isn't content right now for this block.</center>");
define("_ACTIVATECOMMENTS","Activate Comments for this Story?");
define("_NOCOMMENTSACT","Sorry, Comments are not available for this article.");
define("_COMMENTSARTICLES","Activate Comments in Articles?");
define("_UPLOADIMAGE","Upload Image");
define("_COMPLETEVOTE1","Your vote is appreciated.");
define("_COMPLETEVOTE2","You have already voted for this resource in the past $anonwaitdays day(s).");
define("_COMPLETEVOTE3","Vote for a resource only once.<br>All votes are logged and reviewed.");
define("_COMPLETEVOTE4","You cannot vote on a link you submitted.<br>All votes are logged and reviewed.");
define("_COMPLETEVOTE5","No rating selected - no vote tallied");
define("_COMPLETEVOTE6","Only one vote per IP address allowed every $outsidewaitdays day(s).");
define("_MULTILINGUALOPT","Multilingual Options");
define("_ACTMULTILINGUAL","Activate Multilingual features? ");
define("_ACTUSEFLAGS","Display flags instead of a dropdown box? ");
define("_LANGUAGE","Language");
define("_EDITMSG","Edit message");
define("_ADDMSG","Add message");
define("_ALLMESSAGES","Overview messages");
define("_VIEW","Visible to");
define("_REMOVEMSG","Are you sure you want to remove this message ? ");
define("_FILENOTEXIST","Sorry, the file you're trying to access doesn't exist on this system.");
define("_ANNOUNCEPOLL","Announce this new Survey in your site");
define("_LEAVEBLANK","(Leave blank to create a new survey without announce it)");
define("_POLLEDIT","Edit Poll:");
define("_ATTACHEDTOARTICLE","- Attached to article:");
define("_SURVEYSATTACHED","Surveys Attached to Articles");
define("_ATTACHAPOLL","Attach a Poll to this article");
define("_LEAVEBLANKTONOTATTACH","(Leave blank to post the article without any attached Poll)<br>(NOTE: Automated/Programmed news can't have attached Polls)");
define("_ARTICLEPOLL","Article's Poll");

/*****************************************************/
/* Added on PHP-Nuke 5.3                             */
/*****************************************************/

define("_FILENAME","Filename");
define("_FILEINCLUDE","(Select a custom Block to be included. All other fields will be ignored)");
define("_BLOCKPROBLEM","<center>There is a problem right now with this block.</center>");
define("_BLOCKFILE","(Block File)");
define("_EDITPOLL","Edit Polls");
define("_CHOOSEPOLLEDIT","Choose the Poll you want to edit:");
define("_BLOCKPROBLEM2","<center>There isn't content right now for this block.</center>");
define("_ACTIVATECOMMENTS","Activate Comments for this Story?");
define("_NOCOMMENTSACT","Sorry, Comments are not available for this article.");
define("_COMMENTSARTICLES","Activate Comments in Articles?");
define("_UPLOADIMAGE","Upload Image");
define("_COMPLETEVOTE1","Your vote is appreciated.");
define("_COMPLETEVOTE2","You have already voted for this resource in the past $anonwaitdays day(s).");
define("_COMPLETEVOTE3","Vote for a resource only once.<br>All votes are logged and reviewed.");
define("_COMPLETEVOTE4","You cannot vote on a link you submitted.<br>All votes are logged and reviewed.");
define("_COMPLETEVOTE5","No rating selected - no vote tallied");
define("_COMPLETEVOTE6","Only one vote per IP address allowed every $outsidewaitdays day(s).");
define("_MULTILINGUALOPT","Multilingual Options");
define("_ACTMULTILINGUAL","Activate Multilingual features? ");
define("_ACTUSEFLAGS","Display flags instead of a dropdown box? ");
define("_EDITMSG","Edit message");
define("_ADDMSG","Add message");
define("_ALLMESSAGES","Overview messages");
define("_VIEW","Visible to");
define("_REMOVEMSG","Are you sure you want to remove this message ? ");
define("_FILENOTEXIST","Sorry, the file you're trying to access doesn't exist on this system.");
define("_ANNOUNCEPOLL","Announce this new Survey in your site");
define("_LEAVEBLANK","(Leave blank to create a new survey without announce it)");
define("_POLLEDIT","Edit Poll:");
define("_ATTACHEDTOARTICLE","- Attached to article:");
define("_SURVEYSATTACHED","Surveys Attached to Articles");
define("_ATTACHAPOLL","Attach a Poll to this article");
define("_LEAVEBLANKTONOTATTACH","(Leave blank to post the article without any attached Poll)<br>(NOTE: Automated/Programmed news can't have attached Polls)");
define("_ARTICLEPOLL","Article's Poll");
define("_MODULES","Modules");
define("_MODULENOTACTIVE","Sorry, this Module isn't active!");
define("_MODULESADMIN","Modules Administration");
define("_NOACTIVEMODULES","Inactive Modules");
define("_MODULESADDONS","Modules and Addons");
define("_MODULESACTIVATION","See your Modules/Addons current status and change it by Activating or Deactivating them.<br>New Modules copied on the <i>/modules/</i> directory will be automaticaly added with <i>Inactive</i> status to the database when you reload this page.<br>If you want to remove a module just delete it from the <i>/modules/</i> directory, the system will automaticaly update your database to show the changes.");
define("_FORADMINTESTS","(for Admin tests)");

/*****************************************************/
/* Added on PHP-Nuke 5.3.1                           */
/*****************************************************/

define("_NEWSLETTER","Newsletter");
define("_RECEIVENEWSLETTER","Receive Newsletter by Email?");
define("_MASSMAIL","A Massive e-mail to ALL users");
define("_ANEWSLETTER","A Newsletter to subscribed users only");
define("_WHATTODO","What do you want to send?");
define("_SUBSCRIBEDUSERS","Subscribed Users");
define("_NYOUAREABOUTTOSEND","You're about to send a Newsletter to subscribed users.");
define("_NUSERWILLRECEIVE","Users will receive this Newsletter.");
define("_REVIEWTEXT","Please review and check your text:");
define("_NAREYOUSURE2SEND","Are you sure to send this Newsletter now?");
define("_MYOUAREABOUTTOSEND","You're about to send a Massive e-mail to ALL registered users.");
define("_MUSERWILLRECEIVE","Users will receive this Mail.");
define("_MAREYOUSURE2SEND","Are you sure to send this Massive Email now?");
define("_POSSIBLESPAM","Please note that some users may feel disturbed by massive email and may consider this as Spam!");
define("_MASSEMAIL","Massive Email");
define("_MANYUSERSNOTE","WARNING! There are many users that will receive this text. Please wait until the script finish the operation. This can take some minutes to complete!");
define("_NLUNSUBSCRIBE","=========================================================\nYou're receiving this Newsletter because you selected to receive it from your user page at $sitename.\nYou can unsubscribe from this service by clicking in the following URL:\n\n$nukeurl/user.php?op=edituser\"\n\nthen select \"No\" from the option to Receive Newsletter by Email and save your changes, if you need more assistance please contact $sitename administrator.");
define("_NEWSLETTERSENT","The Newsletter has been sent.");
define("_MASSEMAILSENT","Massive Email to all registered users has been sent.");
define("_MASSEMAILMSG","=========================================================\nYou're receiving this email because you're a registered user of $sitename. We hope that this email didn't disturbed you and in some manner contributes to improve our services.");
define("_NOTSUBSCRIBED","You're not subscribed to our Newsletter");
define("_SUBSCRIBED","You're subscribed to our Newsletter");

/**************************************************************************************************/
/* Regional Specific Date texts                                                                   */
/*                                                                                                */
/* A little help for date manipulation, from PHP manual on function strftime():                   */
/*                                                                                                */
/* %a - abbreviated weekday name according to the current locale                                  */
/* %A - full weekday name according to the current locale                                         */
/* %b - abbreviated month name according to the current locale                                    */
/* %B - full month name according to the current locale                                           */
/* %c - preferred date and time representation for the current locale                             */
/* %C - century number (the year divided by 100 and truncated to an integer, range 00 to 99)      */
/* %d - day of the month as a decimal number (range 01 to 31)                                     */
/* %D - same as %m/%d/%y                                                                          */
/* %e - day of the month as a decimal number, a single digit is preceded by a space               */
/*      (range ' 1' to '31')                                                                      */
/* %h - same as %b                                                                                */
/* %H - hour as a decimal number using a 24-hour clock (range 00 to 23)                           */
/* %I - hour as a decimal number using a 12-hour clock (range 01 to 12)                           */
/* %j - day of the year as a decimal number (range 001 to 366)                                    */
/* %m - month as a decimal number (range 01 to 12)                                                */
/* %M - minute as a decimal number                                                                */
/* %n - newline character                                                                         */
/* %p - either `am' or `pm' according to the given time value, or the corresponding strings for   */
/*      the current locale                                                                        */
/* %r - time in a.m. and p.m. notation                                                            */
/* %R - time in 24 hour notation                                                                  */
/* %S - second as a decimal number                                                                */
/* %t - tab character                                                                             */
/* %T - current time, equal to %H:%M:%S                                                           */
/* %u - weekday as a decimal number [1,7], with 1 representing Monday                             */
/* %U - week number of the current year as a decimal number, starting with the first Sunday as    */
/*      the first day of the first week                                                           */
/* %V - The ISO 8601:1988 week number of the current year as a decimal number, range 01 to 53,    */
/*      where week 1 is the first week that has at least 4 days in the current year, and with     */
/*      Monday as the first day of the week.                                                      */
/* %W - week number of the current year as a decimal number, starting with the first Monday as    */
/*      the first day of the first week                                                           */
/* %w - day of the week as a decimal, Sunday being 0                                              */
/* %x - preferred date representation for the current locale without the time                     */
/* %X - preferred time representation for the current locale without the date                     */
/* %y - year as a decimal number without a century (range 00 to 99)                               */
/* %Y - year as a decimal number including the century                                            */
/* %Z - time zone or name or abbreviation                                                         */
/* %% - a literal `%' character                                                                   */
/*                                                                                                */
/*                                                                                                */
/* Note: _DATESTRING is used for Articles and Comments Date                                       */
/*       _LINKSDATESTRING is used for Web Links creation Date                                     */
/*       _DATESTRING2 is used for Older Articles box on Home                                      */
/*                                                                                                */
/**************************************************************************************************/

define("_DATESTRING","%A, %B %d @ %T %Z");
define("_LINKSDATESTRING","%d-%b-%Y");
define("_DATESTRING2","%A, %B %d");

/*****************************************************/
/* Function to translate Datestrings                 */
/*****************************************************/

function translate($phrase) {
    switch($phrase) {
        case "xdatestring":             $tmp = "%A, %B %d @ %T %Z"; break;
        case "linksdatestring": $tmp = "%d-%b-%Y"; break;
        case "xdatestring2":            $tmp = "%A, %B %d"; break;
        default:                        $tmp = "$phrase"; break;
    }
    return $tmp;
}

?>
