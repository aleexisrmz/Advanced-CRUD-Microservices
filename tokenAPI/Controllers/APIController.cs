using Microsoft.AspNetCore.Mvc;
using System.Net.Http.Headers;
using System.Net;
using System.Security.Claims;
using Microsoft.IdentityModel.Tokens;
using System.IdentityModel.Tokens.Jwt;
using System.Text;
using Microsoft.AspNetCore.Authorization;
using tokenAPI.Models;
using Newtonsoft.Json.Linq;
using Newtonsoft.Json;

namespace tokenAPI.Controllers
{

    public class JwtVerifier
    {
        private static string secretKey = "super_secret_key";

        public static async Task<string> VerifyTokenAsync(string token)
        {
            try
            {
                var handler = new JwtSecurityTokenHandler();
                var validationParameters = new TokenValidationParameters
                {
                    ValidateIssuerSigningKey = true,
                    IssuerSigningKey = new SymmetricSecurityKey(Encoding.ASCII.GetBytes(secretKey)),
                    ValidateIssuer = false,
                    ValidateAudience = false
                };

                // Validar el token
                var claimsPrincipal = handler.ValidateToken(token, validationParameters, out var validatedToken);

                // Obtener los datos del token (en este caso, solo 'user')
                var user = claimsPrincipal.FindFirst("user")?.Value;

                // Realizar la lógica adicional con los datos del token
                var response = await MakeApiRequestAsync(user, token);

                return response;
            }
            catch (Exception ex)
            {
                Console.WriteLine($"Error al verificar el token: {ex.Message}");
                return string.Empty;
            }
        }

        private static async Task<string> MakeApiRequestAsync(string user, string token)
        {
            // Aquí puedes realizar la lógica adicional con los datos del token, como enviar una solicitud a una API

            var url = "http://localhost:56169/api/validacion";
            var datos = new { lenguaje = "Python", version = "3.7.3" };

            using (var httpClient = new HttpClient())
            {
                // Establecer el token en el encabezado de autorización
                httpClient.DefaultRequestHeaders.Authorization = new System.Net.Http.Headers.AuthenticationHeaderValue("Bearer", token);

                var response = await httpClient.PostAsJsonAsync(url, datos);
                var resultadoResponse = await response.Content.ReadAsStringAsync();

                return resultadoResponse;
            }
        }
    }

    //[Authorize]
    [ApiController]
    [Route("api/token")]
    public class APIController : ControllerBase
    {
        [HttpGet]
        [AllowAnonymous]
        public IActionResult Get()
        {
            var tokenHeader = Request.Headers["Authorization"].ToString();

            if (!string.IsNullOrEmpty(tokenHeader) && tokenHeader.StartsWith("Bearer ")) 
            {
                var tokenPrincipal = tokenHeader.Substring("Bearer ".Length).Trim();
                var tokenHandler = new JwtSecurityTokenHandler();

                try
                {
                    var tokenJwt = tokenHandler.ReadJwtToken(tokenPrincipal);
                    var exp = tokenJwt.ValidTo;

                    if(exp < DateTime.UtcNow)
                    {
                        return Unauthorized();
                    }

                    string tokenUser = tokenJwt.Claims.FirstOrDefault(c => c.Type == "user")?.Value;

                    if (!String.IsNullOrEmpty(tokenUser))
                    {
                        Ok(new { user = tokenUser});

                        var jsonTokenUser = JsonConvert.SerializeObject(new { user = tokenUser });

                        // Retornar el JSON como resultado de la acción
                        return Content(jsonTokenUser, "application/json");
                    }
                    else
                    {
                        return Unauthorized();
                    }
                }
                catch (Exception)
                {
                    return Unauthorized();
                }
            }
            return Unauthorized();
        }
    }
}