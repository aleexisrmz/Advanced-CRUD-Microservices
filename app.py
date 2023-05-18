import secrets
from flask import Flask, Request, jsonify, request, make_response
from flask_cors import CORS, cross_origin
import pyrebase
import time
import requests
from jwt import encode, decode
from jwt import exceptions
from os import getenv
from datetime import datetime, timedelta
from flask import jsonify
import hashlib

config = {
    "apiKey": "AIzaSyBjpdWZQaEc6_-4KAlRhBxw8MsobnMSry4",
    "authDomain": "serviciosweb-2039.firebaseapp.com",
    "databaseURL": "https://serviciosweb-2039-default-rtdb.firebaseio.com",
    "storageBucket": "serviciosweb-2039.appspot.com"
}

firebase = pyrebase.initialize_app(config)
db = firebase.database()

app = Flask(__name__)
CORS(app)

# def expire_date(days: int):
#    now = datetime.now()
#    now + timedelta(days)


@app.route("/")
def hello_world():
    return "<p>Hello, World!</p>"


@app.route("/ping")
def oing():
    return "<p>Hello, Woasrld!</p>"


@app.route("/products", methods=['GET'])  # type: ignore
def getProducts():
    save = db.child("productos").child("libros").get()
    # # for libros in save.each():
    # #      if libros.key() == "LIB009":
    #           print("true")
    return jsonify(save.val())


@app.route("/login", methods=['POST'])  # type: ignore
@cross_origin(origin='http://localhost/webservices/proyectoRESTslim/')
def getUsuario_sistema():
    user = request.form.get("user")
    password = request.form.get("pass")

    save = db.child("usuario_sistema").child(request.json["user"]).get()
    print(save.key(), save.val())
    # token = secrets.token_hex(7) + request.json["pass"] + secrets.token_hex(9) +secrets.token_hex(4)
    # print(save .val()['pass']) # type: ignore
    if save.val() != None:
        password = request.json["pass"]
        hashed_password = hashlib.md5(password.encode()).hexdigest()
        if save.val()['pass'] == hashed_password:  # type: ignore
            payload = {
                'user': request.json["user"],
                'exp': datetime.utcnow() + timedelta(minutes=1)
            }
            secret_key = 'super_secret_key'
            token = encode(payload, secret_key, algorithm='HS256')

            url = 'http://localhost:56169/api/token'
            # Token que deseas enviar en el encabezado de autorización
            headers = {
                'Authorization': f'Bearer {token}'
            }
            print(token)
            response = requests.post(url, headers=headers)

            resultadoResponse = response.text
            print(resultadoResponse)

            if response.status_code == 405:
                return jsonify({
                    "message": "Post correcto",
                    "token": token,
                    "status": 200
                })
            else:
                return jsonify({
                    "message": "Post incorrecto",
                    "status": 404
                })
        else:
            return jsonify({
                "message": "Error con contraseña"
            })

    #         db.child("token").child("003").push(token)
    else:
        return jsonify({
            "message": "Error con usuario"
        })


if __name__ == '_main_':
    app.run(debug=True, port=5000)
