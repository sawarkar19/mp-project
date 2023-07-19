#!/bin/bash
sudo chown -R ubuntu:ubuntu /var/www/html
sudo chmod -R 777 /var/www/html
sudo chown -R ubuntu:ubuntu /home/gitlab-runner
sudo rm -rf /home/gitlab-runner/builds/cG2W-ttC/0/ratand/openlink/{*,.*}
sudo chown -R gitlab-runner:gitlab-runner /home/gitlab-runner
