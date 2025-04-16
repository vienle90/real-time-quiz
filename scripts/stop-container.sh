#!/bin/bash

# Stop all running containers
podman stop $(podman ps -q)

echo "All containers stopped successfully"