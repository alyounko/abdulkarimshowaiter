import xml.etree.ElementTree as ET
import sqlite3
import os

XML_FILE = r'c:\wamp64\www\abdulkarimshowaiter\WordPress.2026-04-09.xml'
DB_FILE = r'c:\wamp64\www\abdulkarimshowaiter\database.sqlite'

def init_db():
    if os.path.exists(DB_FILE):
        os.remove(DB_FILE)
    
    conn = sqlite3.connect(DB_FILE)
    cursor = conn.cursor()
    
    cursor.execute('''
    CREATE TABLE content (
        id INTEGER PRIMARY KEY,
        post_id INTEGER,
        title TEXT,
        slug TEXT,
        author TEXT,
        content TEXT,
        excerpt TEXT,
        published_date TEXT,
        post_type TEXT,
        status TEXT,
        attachment_url TEXT,
        post_parent INTEGER,
        menu_order INTEGER
    )
    ''')
    
    conn.commit()
    return conn

def import_data():
    conn = init_db()
    cursor = conn.cursor()
    
    print(f"Parsing XML...")
    tree = ET.parse(XML_FILE)
    root = tree.getroot()
    
    namespaces = {
        'wp': 'http://wordpress.org/export/1.2/',
        'content': 'http://purl.org/rss/1.0/modules/content/',
        'dc': 'http://purl.org/dc/elements/1.1/',
        'excerpt': 'http://wordpress.org/export/1.2/excerpt/'
    }
    
    channel = root.find('channel')
    items = channel.findall('item')
    
    count = 0
    for item in items:
        ptype = item.find('wp:post_type', namespaces)
        status = item.find('wp:status', namespaces)
        
        ptype_str = ptype.text if ptype is not None else ''
        status_str = status.text if status is not None else ''
        
        # We only want actual content: pages, posts, and maybe attachments
        if ptype_str not in ['post', 'page', 'attachment']:
            continue
            
        title = item.find('title')
        title_str = title.text if title is not None else ''
        
        slug = item.find('wp:post_name', namespaces)
        slug_str = slug.text if slug is not None else ''
        
        author = item.find('dc:creator', namespaces)
        author_str = author.text if author is not None else ''
        
        content = item.find('content:encoded', namespaces)
        content_str = content.text if content is not None else ''
        
        excerpt = item.find('excerpt:encoded', namespaces)
        excerpt_str = excerpt.text if excerpt is not None else ''
        
        pub_date = item.find('wp:post_date', namespaces)
        pub_date_str = pub_date.text if pub_date is not None else ''
        
        post_id = item.find('wp:post_id', namespaces)
        post_id_int = int(post_id.text) if post_id is not None and post_id.text.isdigit() else 0
        
        post_parent = item.find('wp:post_parent', namespaces)
        post_parent_int = int(post_parent.text) if post_parent is not None and post_parent.text.isdigit() else 0
        
        menu_order = item.find('wp:menu_order', namespaces)
        menu_order_int = int(menu_order.text) if menu_order is not None and menu_order.text.isdigit() else 0
        
        attachment_url = item.find('wp:attachment_url', namespaces)
        attachment_url_str = attachment_url.text if attachment_url is not None else ''
        
        cursor.execute('''
        INSERT INTO content (post_id, title, slug, author, content, excerpt, published_date, post_type, status, attachment_url, post_parent, menu_order)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ''', (post_id_int, title_str, slug_str, author_str, content_str, excerpt_str, pub_date_str, ptype_str, status_str, attachment_url_str, post_parent_int, menu_order_int))
        
        count += 1
        
    conn.commit()
    conn.close()
    print(f"Successfully inserted {count} rows into database.sqlite.")

if __name__ == '__main__':
    import_data()
