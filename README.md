# Simple Laravel REST API Deployment with AWS CloudFormation

This project demonstrates how to deploy a **simple Laravel REST API** (with one CRUD resource: `posts`) on AWS using **CloudFormation**. The entire infrastructure — VPC, Subnet, Internet Gateway, EC2 instance (Amazon Linux 2023), RDS MySQL database, and Security Groups — is defined as code in a single CloudFormation template.

The Laravel application is automatically installed, configured, and migrated during EC2 boot using `cfn-init`.

## Features

- Fully automated infrastructure deployment via CloudFormation
- Laravel 11 (or latest) application with a single CRUD API resource (`/api/posts`)
- MySQL database on Amazon RDS
- Apache web server on EC2 serving the Laravel `public/` directory
- Publicly accessible HTTP endpoint (add HTTPS in production)
- Free-tier eligible resources (t2.micro EC2 + db.t3.micro RDS)
- Easy cleanup by deleting the stack

## Prerequisites

1. An AWS account with billing enabled (use Free Tier to minimize costs)
2. AWS Console access with permissions:
   - `AWSCloudFormationFullAccess`
   - `AmazonEC2FullAccess`
   - `AmazonRDSFullAccess`
   - `AmazonVPCFullAccess`
3. A public GitHub repository containing your Laravel project
4. (Recommended) An EC2 Key Pair for SSH debugging

## Laravel Application Setup (Local)

Before deploying, create and push your Laravel app:

```bash
composer create-project laravel/laravel simple-rest-api
cd simple-rest-api

# Generate model, migration, and API controller
php artisan make:model Post -mcr --api

# Run migrations and test locally (use SQLite for simplicity)
php artisan migrate
php artisan serve
```

## Cloudformation infrustructure Canvas
<img width="1252" height="610" alt="image" src="https://github.com/user-attachments/assets/7dbb7746-0bc5-4ba6-a0e9-05d2041bf86d" />

### CloudFormation Template Overview
The template (laravel-stack.yaml) creates:

A VPC with one public subnet
Internet Gateway and route table
Security Groups (HTTP + SSH for EC2, MySQL for RDS)
RDS MySQL 8.0 instance (db.t3.micro)
EC2 instance (t2.micro, Amazon Linux 2023)
Automated setup via AWS::CloudFormation::Init:
Install Apache, PHP 8.2+, Composer, Git
Clone your repo
Run composer install
Configure .env with RDS details
Run migrations
Set up Apache virtual host

Deployment Steps

Download the CloudFormation template (provided below).
Go to AWS Console → CloudFormation → Create stack.
Upload laravel-stack.yaml.
Fill parameters:
GitRepoUrl: Your public GitHub URL (e.g., https://github.com/yourusername/simple-rest-api.git)
DBPassword: Strong password (8+ characters)
KeyName: (Optional) Your EC2 key pair name for SSH access

Acknowledge capabilities and create the stack.
Wait 15–25 minutes until status is CREATE_COMPLETE.


