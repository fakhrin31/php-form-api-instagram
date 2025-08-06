# Instagram Content Publisher via PHP + Cloudinary

A simple PHP application to upload an image with a caption to an Instagram Business Account using the Instagram Graph API and Cloudinary for image hosting.

## 📍 Features

-   Uploads product images to a Cloudinary account.
-   Publishes the image and caption to an Instagram feed using the Graph API.
-   Provides a simple form for input:
    -   Product Title
    -   Product Description
    -   Product Image
-   Uses a `.env` file to securely store API keys and credentials.

---

## 🗂️ Project Structure

This project uses the following structure:

```
/your-project-root
|
|-- /form
|   |-- index.php           # The main form for user input
|   |-- post.php            # Handles form submission and API calls
|
|-- /vendor                 # Composer dependencies (auto-generated)
|
|-- .env                    # Environment variables (DO NOT COMMIT)
|-- composer.json           # Project dependencies
|-- README.md               # This file
```

---

## ⚙️ Prerequisites

Before you begin, ensure you have the following:

1.  An **Instagram Business Account** connected to a **Facebook Page**.
2.  A **Facebook App** with the following permissions granted:
    -   `instagram_basic`
    -   `pages_show_list`
    -   `instagram_content_publish`
3.  The **Instagram Graph API** enabled in your Facebook App.
4.  The following credentials:
    -   Your **Instagram Business Account ID**.
    -   A non-expiring **User Access Token**.
5.  A **Cloudinary Account** with the following details:
    -   `Cloud Name`
    -   `API Key` & `API Secret` (for server-side uploads)

---

## 🔑 Setup

### 1. Clone the Repository

```bash
git clone <your-repository-url>
cd your-project-root
```

### 2. Install Dependencies

This project uses [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) to manage environment variables and [cloudinary/cloudinary_php](https://github.com/cloudinary/cloudinary_php) for image uploads. Install them using Composer.

```bash
composer require vlucas/phpdotenv cloudinary/cloudinary_php
```

This will create the `vendor` directory and the `composer.json` file.

### 3. Configure Environment Variables

Create a `.env` file in the root of the project. **This file should be added to `.gitignore` to prevent leaking your credentials.**

```env
# Instagram API Credentials
INSTAGRAM_USER_ID=your_instagram_business_account_id
ACCESS_TOKEN=your_permanent_facebook_page_access_token

# Cloudinary Credentials
CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
```

---

## 🚀 How to Use

1.  Navigate to `http://your-local-domain/form/index.php` in your web browser.
2.  Fill out the form with a title, description, and select an image.
3.  Click "Publish to Instagram".
4.  The form will submit to `post.php`, which will upload the image to Cloudinary, get the public URL, and then post it to your Instagram account.
