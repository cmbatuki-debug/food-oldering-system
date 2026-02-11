# GitHub Setup & Push Instructions

## Step 1: Install Git (if not installed)

1. Download Git from: https://git-scm.com/download/win
2. Run the installer
3. **Important:** During installation, check "Add Git to PATH"
4. Complete the installation

## Step 2: Find Git Installation Path (if already installed)

If Git is installed but not in PATH:
1. Common installation locations:
   - `C:\Program Files\Git\bin\git.exe`
   - `C:\Program Files\Git\cmd\git.exe`
   - `C:\Program Files (x86)\Git\bin\git.exe`

2. To add Git to PATH temporarily in Command Prompt:
   ```
   set PATH=C:\Program Files\Git\bin;%PATH%
   ```
   (Replace path with your actual Git installation path)

3. To add Git to PATH permanently:
   - Search for "Environment Variables" in Windows
   - Click "Environment Variables"
   - Under "System variables", find "Path", click "Edit"
   - Click "New" and add the path to Git\bin (e.g., `C:\Program Files\Git\bin`)
   - Click "OK" to save

## Step 3: Configure Git

Open Command Prompt in your project folder and run:

```cmd
cd c:\xampp\htdocs\food\ oldering
```

Then configure your name and email:
```cmd
git config --global user.name "Your Username"
git config --global user.email "your.email@example.com"
```

## Step 4: Initialize Repository & Push to GitHub

### Option A: Create new repository on GitHub

1. Go to https://github.com/new
2. Repository name: `food-ordering-system`
3. Description: "A complete food ordering website built with PHP and MySQL"
4. Make it Public or Private
5. Click "Create repository" (don't initialize with README)
6. Copy the repository URL (e.g., `https://github.com/yourusername/food-ordering-system.git`)

### Option B: Push existing repository

Run these commands in Command Prompt:

```cmd
cd c:\xampp\htdocs\food\ oldering

git init
git add .
git commit -m "Initial commit - Food ordering system"

git branch -M main
git remote add origin https://github.com/yourusername/food-ordering-system.git
git push -u origin main
```

### If you get authentication errors:

1. Use GitHub Personal Access Token instead of password:
   - Go to https://github.com/settings/tokens
   - Generate new token (classic)
   - Select "repo" scope
   - Copy the token
   - When prompted for password, paste the token instead

## Alternative: Using GitHub Desktop

1. Download GitHub Desktop from https://desktop.github.com/
2. Install and sign in to your GitHub account
3. Click "Add an Existing Repository"
4. Select `c:\xampp\htdocs\food\ oldering`
5. Click "Publish repository"

## Files Already Prepared

I've created the following files for you:
- `.gitignore` - Excludes sensitive files (uploads, logs, etc.)
- `README.md` - Already exists with project documentation

## Quick Commands Reference

```cmd
# Initialize new repository
git init

# Stage all files
git add .

# Commit
git commit -m "Your commit message"

# Push to GitHub
git push origin main

# Pull from GitHub
git pull origin main

# Check status
git status
```
