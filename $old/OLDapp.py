# def countdown(num_of_secs):
#     while num_of_secs:
#         m, s = divmod(num_of_secs, 60)
#         min_sec_format = '{:02d}:{:02d}'.format(m, s)
#         time.sleep(1)
#         num_of_secs -= 1
#     db.child("token").child("004").remove()





# @app.route("/products",methods=['GET'])
# def getProducts():
#     return jsonify(productos)

# @app.route("/products",methods=['POST'])
# def setproduct():
#     new_productos = {
#          "name": request.json['name'],
#          "id": request.json['id']
#     }
#     print(request.json)
#     productos.append(new_productos)
#     return jsonify({"message":"Producto agregaado","productos ":productos})




# @app.route("/login/succesful",methods=['GET'])
# def timer():
#     countdown(10)
#     return "hola"


        


# # @app.route('/products/<string:product_id>',methods=['PUT'])
# # def editProductos(product_id):
# #     productFound = [ product for product in productos if product["id"]== product_id]
# #     if (len(productFound)>0):
# #             productFound[0]['name'] = request.json['name']
# #             productFound[0]['id'] = request.json['id']
# #             return jsonify({
# #                  "message": "product update",
# #                  "product": productFound[0]
# #             })

# #     return jsonify({"producto no found"})
# # @app.route('/products/<string:product_id>',methods=['DELETE'])
# # def deleteProduct(product_id):
# #     productFound = [ product for product in productos if product["id"]== product_id]
# #     if (len(productFound)>0):
# #             productos.remove(productFound[0])
# #             return jsonify({
# #                  "message": "producto eliminado",
# #                  "productos": productos
# #             })

# #     return jsonify({"producto no found"})

# @app.route("/products/<string:product_id>")
# def getProduct(product_id):
#     print(product_id)
#     productFound = [product for product in productos  if product["id"] == product_id] 
#     if (len(productFound)>0):
#         return jsonify({"producto":productFound})
#     return jsonify({"mensaje": "producto not found"})




################################################################
#OLD VERSIONS


@app.route("/login",methods=['POST']) # type: ignore
def getUsuario_sistema():

        save =  db.child("usuario_sistema").child(request.json["user"]).get()
        print(save.key(),save.val())
        token = secrets.token_hex(7) + request.json["pass"] + secrets.token_hex(9) +secrets.token_hex(4)
        # print(save .val()['pass']) # type: ignore
        if save.val() != None:
            if save.val()['pass'] == request.json["pass"]:  # type: ignore
                resp = make_response()
                resp.headers['token'] = token
                return resp 
            else:
                return jsonify({
                  "message": "Error"
                })
                 
        #         db.child("token").child("003").push(token)       
        else:
             return jsonify({
                  "message": "Error"
            })