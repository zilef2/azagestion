Tamaño de archivos
{
    usuarios => 2MB | 2048 KB
    Seguimiento => 21000 lineas | 8MB | 8192 KB
    soporte(Adjuntos) => sin limite  TODDO:: poner max de 10MB
    Foto => 2MB | 2048 KB
}

si se asume un peso de los Soportes de 0.5 Mb en promedio, con 250.000 archivos (max: 100GB)
si se asume que diario suben 100 archivos, tendria capacidad para 7 años

Contraseñas
{
    la longuitud debe ser de mas de 8 caracteres
}

- La tabla donde aparecen las ordenes aprobadas, solo seran las que fueron generadas hace 4 meses

comportamiento del software al subir un archivo
{

    subir usuarios{
        'correo' existe ? 
            entonces se actualiza
            si no, se busca por nombre y se actualiza
            si no, se crea un nuevo usuario
    }
    subir OC
    {
        - Empresas, tareas y clasificaciones se crean si no existen
        - OC (codigo) se crean si no existen,
            si existen se actualiza: 
                fecha
                horas aprobadas
                empresa
                tarea
                clasificacion
                Si esta ejecutada o no

                -CASO DE SOBREESCRITURA
                    cuando se cambia el prestador, Pao y ahora queda de alejandro
                    si no se a tocado la orden{
                        solo se reemplaza
                    }si ya tiene ordenes{
                        debe guardar info de ambos prestadores
                        
                    }

        usuarios (nombre): se crean si no existen
            si la OC es nueva se le asigna dicho usuario
    }

}

//seguridad antipishing

Educate Yourself: Understand what phishing is, how it works, and the techniques used by phishers to trick users. This knowledge will help you better protect your website and users.
Use SSL/TLS Certificates: Implement Secure Sockets Layer (SSL) or Transport Layer Security (TLS) certificates on your website. This ensures that all communication between your website and users is encrypted, making it difficult for attackers to intercept sensitive information.
Implement Anti-Phishing Measures: Deploy anti-phishing technologies and services that can identify and block known phishing websites, links, or emails. These solutions often use databases of known phishing sources to provide real-time protection.
Enable Email Authentication: Implement email authentication mechanisms such as Sender Policy Framework (SPF), DomainKeys Identified Mail (DKIM), and Domain-based Message Authentication, Reporting, and Conformance (DMARC). These measures help prevent attackers from spoofing your domain and sending phishing emails on your behalf.

Use Multi-Factor Authentication (MFA): Implement MFA on your website to add an extra layer of security for user logins. This can include methods such as SMS verification codes, authenticator apps, or biometric verification.

Regularly Update and Patch Your Software: Keep your website's software, content management systems (CMS), plugins, and themes up to date. Regularly apply security patches and updates to address vulnerabilities that could be exploited by attackers.

Implement User Awareness Training: Educate your website users about phishing techniques, warning signs, and best practices for staying safe online. Teach them not to click on suspicious links or provide sensitive information unless they are certain of the source's legitimacy.

Monitor for Suspicious Activity: Use website analytics and security monitoring tools to detect and investigate any suspicious activity or unauthorized access attempts. Monitor for indicators of compromise and take appropriate action if any malicious activity is detected.

Implement Strong Password Policies: Enforce strong password requirements for user accounts on your website. Encourage users to choose unique, complex passwords and regularly update them.

Provide Reporting Mechanisms: Include clear instructions and reporting mechanisms on your website, enabling users to report any phishing attempts they encounter. Promptly investigate and respond to reports to mitigate potential threats.



