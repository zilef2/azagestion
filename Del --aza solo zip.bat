@echo on
set destination=C:\laragon\www\azagestion\azagestion.zip
del %destination%
"C:\Program Files\7-Zip\7z.exe" a -r -x!"C:\laragon\www\azagestion\vendor" -x!"C:\laragon\www\azagestion\storage" -x!"C:\laragon\www\azagestion\node_modules" -x!"C:\laragon\www\azagestion\public\hot"  %destination% "C:\laragon\www\azagestion\app" "C:\laragon\www\azagestion\resources" "C:\laragon\www\azagestion\routes" "C:\laragon\www\azagestion\database" "C:\laragon\www\azagestion\config"