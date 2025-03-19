#!/bin/bash

# Navigate to your GitHub repo directory
cd /workspaces/Lost-Paws/View/pet-uploads

# Pull the latest changes from GitHub (optional if you want to sync from GitHub too)
git pull origin main

# Copy files from the Hostinger directory to the GitHub repo
cp /home/u204807276/domains/pawsarelost.com/public_html/lostpaws_html/View/pet-uploads/* /workspaces/Lost-Paws/View/pet-uploads/

# Add new files to git
git add pet-uploads/*

# Commit the new files
git commit -m "Automated upload of new pet files"

# Push the changes to GitHub
git push origin main
