#!/bin/bash
if ! grep -q "fs.inotify.max_user_watches" /etc/sysctl.conf; then
    echo "Setting fs.inotify.max_user_watches=524288"
    echo fs.inotify.max_user_watches=524288 | sudo tee -a /etc/sysctl.conf
    sudo sysctl -p
else
    echo "fs.inotify.max_user_watches already set."
fi
