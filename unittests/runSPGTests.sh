cp -rfp /home/training/devel/oxid445/modules/copy_this/* /home/training/devel/oxid445/eshop/
cp -rfp /home/training/devel/oxid445/modules/unit_tests/* /home/training/devel/oxid445/unittests
oxPATH=/home/training/devel/oxid445/eshop/ oxADMIN_PASSWD=123456 phpunit -d "memory_limit=512M" --verbose --bootstrap bootstrap.php AllNXSSPGTests.php
