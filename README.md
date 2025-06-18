<h1 align="center">🎨 Creative Gallery</h1>
<p align="center"><strong>Laravel-based Online Art Auction Platform</strong></p>
<p align="center">
    <img src="https://img.shields.io/badge/Laravel-10-red" />
    <img src="https://img.shields.io/badge/license-MIT-blue" />
    <img src="https://img.shields.io/badge/status-Under_Development-yellow" />
</p>

<hr>

<h2>📚 About the Project</h2>
<p>
    <strong>Creative Gallery</strong> is an art auction web application where artists can submit their artwork for approval, and users can explore and bid on available pieces. Admins can approve or reject submissions, while users enjoy a visually engaging gallery and bidding experience.
</p>

<hr>

<h2>🚀 Features</h2>

<h3>👥 Users</h3>
<ul>
    <li>View artworks in a responsive grid</li>
    <li>Details include artwork title, category, description, and price</li>
    <li>Pre-signup bidding button for engagement</li>
    <li>Visual alert for unverified users</li>
</ul>

<h3>🛠️ Administrators</h3>
<ul>
    <li>Dashboard to view all artwork requests</li>
    <li>Approve or reject artwork with buttons</li>
    <li>Modal view of proof of ownership videos</li>
    <li>Badge-based artwork status (e.g., New)</li>
</ul>

<hr>

<h2>🧰 Tech Stack</h2>
<ul>
    <li><strong>Backend:</strong> Laravel 10.x</li>
    <li><strong>Frontend:</strong> Blade, HTML5, Bootstrap 4, jQuery</li>
    <li><strong>Database:</strong> MySQL</li>
    <li><strong>Icons & UI:</strong> Font Awesome, AdminLTE</li>
</ul>

<hr>

<h2>📦 Installation</h2>

<pre>
git clone https://github.com/qppd/Creative-Gallery.git
cd Creative-Gallery
composer install
npm install && npm run dev
cp .env.example .env
php artisan key:generate
</pre>

<h3>⚙️ Configure Environment</h3>
Update your `.env` file with DB credentials:

<pre>
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
</pre>

<h2>📁 Project Structure</h2>
<pre>
resources/views/
├── administrator/
│   ├── includes/
│   ├── modals/
│   └── requests.blade.php
├── user/
│   ├── includes/
│   └── login.blade.php
</pre>

<hr>

<h2>📄 License</h2>
<p>This project is licensed under the <strong>MIT License</strong> — feel free to use and modify it.</p>

<hr>

<h2>🙌 Acknowledgments</h2>
<p>Developed by <a href="https://github.com/qppd">QPPD</a> for artists, collectors, and creative communities. Contributions and stars are welcome!</p>
