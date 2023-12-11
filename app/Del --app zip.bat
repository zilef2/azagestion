@echo on
set destination=C:\laragon\www\azagestion\app\http.zip
del %destination%
"C:\Program Files\7-Zip\7z.exe" a -r -x!"C:\laragon\www\azagestion\vendor" -x!"C:\laragon\www\azagestion\storage" -x!"C:\laragon\www\azagestion\node_modules" -x!"C:\laragon\www\azagestion\public\hot"  %destination% "C:\laragon\www\azagestion\app\Http"