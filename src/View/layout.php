<?php
// Usage: include this file, set $title and $content before calling
// We use a simple header/footer pattern instead of output buffering

function renderLayout(string $title, string $content): void {
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{$title} – SalesAutopilot</title>
        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body { font-family: system-ui, sans-serif; background: #f5f5f5; color: #333; }
            header { background: #1a73e8; color: white; padding: 1rem 2rem; }
            header a { color: white; text-decoration: none; font-size: 1.1rem; font-weight: bold; }
            main { max-width: 960px; margin: 2rem auto; padding: 0 1rem; }
            table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.1); }
            th { background: #1a73e8; color: white; padding: 0.75rem 1rem; text-align: left; }
            td { padding: 0.75rem 1rem; border-bottom: 1px solid #eee; }
            tr:last-child td { border-bottom: none; }
            tr:hover td { background: #f0f7ff; }
            .error-box { background: #fff3f3; border: 1px solid #f5c6cb; border-radius: 8px; padding: 1.5rem; color: #721c24; }
            .error-box h2 { margin-bottom: 0.5rem; }
            .error-box a { display: inline-block; margin-top: 1rem; color: #1a73e8; }
            .info { color: #666; margin: 1rem 0; }
            .filter-bar { background: white; padding: 1rem; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); margin-bottom: 1.5rem; display: flex; gap: 1rem; align-items: center; flex-wrap: wrap; }
            .filter-bar input, .filter-bar select { padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; font-size: 0.95rem; }
            .filter-bar button { padding: 0.5rem 1rem; background: #1a73e8; color: white; border: none; border-radius: 4px; cursor: pointer; }
            .filter-bar button:hover { background: #1558b0; }
            .btn { display: inline-block; padding: 0.4rem 0.9rem; background: #1a73e8; color: white; border-radius: 4px; text-decoration: none; font-size: 0.9rem; }
            .btn:hover { background: #1558b0; }
            .back-link { display: inline-block; margin-bottom: 1rem; color: #1a73e8; text-decoration: none; }
            .back-link:hover { text-decoration: underline; }
            .empty { color: #888; font-style: italic; padding: 1rem 0; }
        </style>
    </head>
    <body>
        <header>
            <a href="?page=lists">📋 SalesAutopilot Listák</a>
        </header>
        <main>
            <h1 style="margin-bottom:1.5rem; margin-top:0.5rem;">{$title}</h1>
            {$content}
        </main>
    </body>
    </html>
    HTML;
}