

mysql -u root -p dashcorretores -e "LOAD DATA INFILE '/var/www/html/conversa_backup_202604171519.csv'
INTO TABLE conversa_backup
FIELDS TERMINATED BY ','
ENCLOSED BY '\"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;"