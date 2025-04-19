package me.tx0ndev.controlPlayers;
import org.bukkit.Bukkit;
import org.bukkit.entity.Player;
import org.bukkit.plugin.java.JavaPlugin;

import com.sun.net.httpserver.HttpServer;
import com.sun.net.httpserver.HttpHandler;
import com.sun.net.httpserver.HttpExchange;

import java.io.IOException;
import java.io.OutputStream;
import java.net.InetSocketAddress;

public final class ControlPlayers extends JavaPlugin {

    @Override
    public void onEnable() {
        try {
            HttpServer server = HttpServer.create(new InetSocketAddress(8080), 0);
            server.createContext("/action", new ActionHandle());
            server.setExecutor(null);
            server.start();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    static class ActionHandle implements HttpHandler {
        @Override
        public void handle(HttpExchange exchange) throws IOException {
            String query = exchange.getRequestURI().getQuery();
            String[] params = query != null ? query.split("&") : new String[0];
            String type = null, playerName = null;

            for (String param : params) {
                if (param.startsWith("type=")) type = param.split("=")[1];
                if (param.startsWith("player=")) playerName = param.split("=")[1];
            }

            String response;
            if (playerName != null && type != null) {
                Player target = Bukkit.getPlayer(playerName);
                if (target != null) {
                    String finalType = type;
                    Bukkit.getScheduler().runTask(JavaPlugin.getProvidingPlugin(ControlPlayers.class), () -> {
                        //main
                        if(finalType.equals("kick")){
                            target.kickPlayer("You have been kicked by admin.");
                        } else if (finalType.equals("kill")) {
                            target.setHealth(0);
                        } else if (finalType.equals("rsHeart")) {
                            target.setHealth(20.0);
                        }
                    });
                    response = "Player " + playerName + " has been kicked.";
                } else {
                    response = "Player not found.";
                }
            } else {
                response = "Missing player parameter.";
            }

            exchange.sendResponseHeaders(200, response.length());
            OutputStream os = exchange.getResponseBody();
            os.write(response.getBytes());
            os.close();
        }
    }
}