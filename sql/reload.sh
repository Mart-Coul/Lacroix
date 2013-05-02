mysqladmin -u root -p drop lacroix
mysqladmin -u root -p create lacroix
cat init.sql migration*.sql | mysql -u root -p lacroix