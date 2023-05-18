using System.Security.Claims;

namespace tokenAPI.Models
{
    public class Jwt
    {
        public static dynamic ValidarToken(ClaimsIdentity identity)
        {
            try
            {
                if (identity.Claims.Count() == 0) 
                {
                    return new
                    {
                        success = false,
                        message = "Verificar si estas enviando un token valido",
                        result = ""
                    };
                }

                return new
                {
                    success = true,
                    message = "Exito",
                    result = ""
                };

            }
            catch 
            {
                return new
                {
                    succes = false,
                    message = "Error",
                    result = ""
                };
            }
        }
    }
}
