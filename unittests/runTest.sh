cp -rfp /home/training/devel/oxid445/modules/copy_this/* /home/training/devel/oxid445/eshop
cp -rfp /home/training/devel/oxid445/modules/unit_tests/* /home/training/devel/oxid445/unittests
oxphpmd /home/training/devel/oxid445/modules/copy_this text oxid > /home/training/devel/oxid445/unittests/metrics/phpmd.txt
pdepend --jdepend-chart=/home/training/devel/oxid445/unittests/metrics/dependchart.svg --overview-pyramid=/home/training/devel/oxid445/unittests/metrics/dependpyramid.svg /home/training/devel/oxid445/modules/copy_this/
oxPATH=/home/training/devel/oxid445/eshop/ CODECOVERAGE=1 oxADMIN_PASSWD='123456' phpunit -d 'memory limit=512M' --verbose --bootstrap bootstrap.php --coverage-html=report/ --log-metrics report.xml AllNXSSPGTests.php
php MC_Metrics.php report.xml > spg_metrics.txt
