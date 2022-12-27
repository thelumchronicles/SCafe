package com.doan.scafe;

import com.google.gson.JsonObject;

import java.util.List;

import okhttp3.MultipartBody;
import okhttp3.RequestBody;
import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.http.Body;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.Part;
import retrofit2.http.Path;

public interface SCafeHolderAPI {
    @GET("csrfToken")
    Call<String> getCSRF();

    @POST("login")
    Call<String> login(@Body Credentials credentials);

    @GET("getLoggedDetail")
    Call<LoggedDetail> getLoggedDetail();

    @POST("changePassword")
    Call<String> postChangePassword(@Body ChangePassword changePassword);

    @GET("getRooms")
    Call<List<Room>> getRooms();

    @GET("getTables")
    Call<List<Table>> getTables();

    @GET("getTablesWithRoomID/{room_id}")
    Call<List<Table>> getTablesWithRoomID(@Path(value = "room_id", encoded = true) int room_id);

    @GET("getTablesCustoms/{status}")
    Call<List<Table>> getTablesWithStatus(@Path(value = "status", encoded = true) int type);

    @GET("getTablesCustoms/{room_id}/{status}")
    Call<List<Table>> getTablesWithStatusAndRoomID(@Path(value = "room_id", encoded = true) int room_id , @Path(value = "status", encoded = true) int status);

    @GET("getProductCategories")
    Call<List<Category>> getProductCategories();

    @GET("getAllProducts/{category_id}")
    Call<List<Product>> getAllProducts(@Path(value = "category_id", encoded = true) int category_id);

    @GET("getTableDetail/{table_id}")
    Call<TableDetail> getTableDetail(@Path(value = "table_id", encoded = true) int table_id);

    @GET("getProductsInTable/{table_id}")
    Call<List<ProductInTable>> getProductsInTable(@Path(value = "table_id", encoded = true) int table_id);

    @GET("increaseAmount/{id}/{invoice_id}")
    Call<String> increaseAmount(@Path(value = "id", encoded = true) int id  , @Path(value = "invoice_id", encoded = true) int invoice_id);

    @GET("decreaseAmount/{id}/{invoice_id}")
    Call<String> decreaseAmount(@Path(value = "id", encoded = true) int id  , @Path(value = "invoice_id", encoded = true) int invoice_id);

    @GET("deleteProduct/{id}/{invoice_id}")
    Call<String> deleteProduct(@Path(value = "id", encoded = true) int id  , @Path(value = "invoice_id", encoded = true) int invoice_id);

    @GET("getDiscounts/{invoice_id}")
    Call<List<Discount>> getDiscounts(@Path(value = "invoice_id", encoded = true) int invoice_id);

    @GET("setDiscount/{discount_id}/{invoice_id}")
    Call<String> setDiscount(@Path(value = "discount_id", encoded = true) int discount_id  , @Path(value = "invoice_id", encoded = true) int invoice_id);

    @GET("resetDiscount/{invoice_id}")
    Call<String> resetDiscount(@Path(value = "invoice_id", encoded = true) int invoice_id );

    @GET("prepareTable/{table_id}")
    Call<String> prepareTable(@Path(value = "table_id", encoded = true) int table_id );

    @GET("themThucDon/{invoice_id}/{product_id}/{amount}")
    Call<String> themThucDon(@Path(value = "invoice_id", encoded = true) int invoice_id , @Path(value = "product_id", encoded = true) int product_id ,@Path(value = "amount", encoded = true) int amount);

    @GET("huyThucDon/{invoice_id}")
    Call<String> huyThucDon(@Path(value = "invoice_id", encoded = true) int invoice_id);

    @GET("getSeparateTable/{table_id}")
    Call<Table> getSeparateTable(@Path(value = "table_id", encoded = true) int table_id);

    @GET("thanhToan/{invoice_id}")
    Call<String> thanhToan(@Path(value = "invoice_id", encoded = true) int invoice_id);


}
