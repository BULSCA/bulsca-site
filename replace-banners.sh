#!/bin/bash

# Script to replace banner blocks with page-banner component

python3 << 'PYTHON_SCRIPT'
import os
import re
from pathlib import Path

# Pattern to match the banner block
banner_pattern = re.compile(
    r'<div class="h-\[40vh\] w-screen bg-gray-100  overflow-hidden  ">\s*'
    r'<div class="h-full w-full overflow-hidden relative">\s*'
    r'<div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">\s*'
    r'<img src="[^"]*" class="[^"]*" alt="">\s*'
    r'<div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">\s*'
    r'<h2 class="md:text-6xl text-4xl font-bold text-white">([^<]*)</h2>\s*'
    r'(?:<p class="text-white">([^<]*)</p>\s*)?'
    r'</div>\s*'
    r'</div>\s*'
    r'</div>\s*'
    r'</div>',
    re.MULTILINE | re.DOTALL
)

# Find all blade files
for blade_file in Path('resources/views').rglob('*.blade.php'):
    with open(blade_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Check if file contains the pattern
    if 'class="h-[40vh] w-screen bg-gray-100  overflow-hidden  "' in content:
        print(f"Processing: {blade_file}")
        
        def replace_banner(match):
            title = match.group(1).strip()
            subtitle = match.group(2).strip() if match.group(2) else None
            
            if subtitle:
                return f'<x-page-banner\n    title="{title}"\n    subtitle="{subtitle}"\n    :snowContainer="true"\n/>'
            else:
                return f'<x-page-banner\n    title="{title}"\n    :snowContainer="true"\n/>'
        
        new_content = banner_pattern.sub(replace_banner, content)
        
        if new_content != content:
            with open(blade_file, 'w', encoding='utf-8') as f:
                f.write(new_content)
            print(f"  ✓ Replaced banner in {blade_file}")
        else:
            print(f"  - No changes needed in {blade_file}")

print("Done!")
PYTHON_SCRIPT