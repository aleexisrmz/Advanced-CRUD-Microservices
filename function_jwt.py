from jwt import encode, decode
from jwt import exceptions
from os import getenv
from datetime import datetime, timedelta
from flask import jsonify

def expire_date(days: int):
    now = datetime.now()
    now + timedelta(days)
    

def write_token(data: dict):
    token = encode(payload={**data, "exp": expire_date(2)}, key=getenv("SECRET"), algorithm="HS256")
    return token.encode("UTF-8")



# Validar el token (No se debería usar)

def validar_token(token, output=False):
    try:
        if output:
            return decode(token, key=getenv("SECRET"), algorithms=["HS245"])
    except exceptions.DecodeError:
        response = jsonify({"message": "Not Authorized"})
        response.status_code = 401
    except exceptions.ExpiredSignatureError:
        response = jsonify({"message": "Token expired"})
        response.status_code = 402