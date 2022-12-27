package com.doan.scafe;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Filter;
import android.widget.Filterable;
import android.widget.SearchView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import org.jetbrains.annotations.NotNull;

import java.text.Normalizer;
import java.util.ArrayList;
import java.util.List;
import java.util.regex.Pattern;

public class ChooseCategory extends AppCompatActivity {
    RecyclerView recyclerView;
    ChooseCategoryAdapter chooseCategoryAdapter;
    ArrayList<Category> categoriesAll;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.choose_category_layout);
        TextView tableNameDisplay = findViewById(R.id.txtTableNameDisplay);
        tableNameDisplay.setText(GlobalVar.currentSystemTableName);

        Toolbar toolbar = findViewById(R.id.toolBar3);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayShowTitleEnabled(false);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        recyclerView = findViewById(R.id.categoryRecyclerView);
        ArrayList<Category> categories = new ArrayList<>();
        categoriesAll = new ArrayList<>();

        chooseCategoryAdapter = new ChooseCategoryAdapter(ChooseCategory.this, categories , categoriesAll);

        GlobalVar.sCafeFunctions.getProductCategories(categories , categoriesAll,chooseCategoryAdapter);


        LinearLayoutManager linearLayoutManager = new LinearLayoutManager(this);
        DividerItemDecoration dividerItemDecoration = new DividerItemDecoration(recyclerView.getContext(),
                linearLayoutManager.getOrientation());
        recyclerView.addItemDecoration(dividerItemDecoration);
        recyclerView.setAdapter(chooseCategoryAdapter);
        recyclerView.setLayoutManager(linearLayoutManager);
    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {

        getMenuInflater().inflate(R.menu.searchcategory_menu, menu);
        MenuItem item = menu.findItem(R.id.action_search);
        SearchView searchView = (SearchView)item.getActionView();
        searchView.setIconified(false);
        searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String query) {
                return false;
            }

            @Override
            public boolean onQueryTextChange(String newText) {
                chooseCategoryAdapter.getFilter().filter(newText);
                return false;
            }
        });


        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                onBackPressed();
                return true;

            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();
        Intent myIntent = new Intent(ChooseCategory.this, OrderedTable.class);
        startActivity(myIntent);
        finish();
    }
}

class ChooseCategoryAdapter extends RecyclerView.Adapter<ChooseCategoryAdapter.ViewHolder> implements Filterable {


    ArrayList<Category> categories;
    ArrayList<Category> categoriesAll;
    LayoutInflater inflater;

    public ChooseCategoryAdapter(Context ctx, ArrayList<Category> categories , ArrayList<Category> categoriesAll) {
        this.categories = categories;
        this.categoriesAll = categoriesAll;
        this.inflater = LayoutInflater.from(ctx);
    }


    @NonNull
    @NotNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull @NotNull ViewGroup parent, int viewType) {
        View view = inflater.inflate(R.layout.choose_category_item, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull @NotNull ViewHolder holder, int position) {
        holder.txtCategoryName.setText(categories.get(position).category_name);
        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                GlobalVar.currentSystemCategoryID = categories.get(position).category_id;
                GlobalVar.currentSystemCategoryName = "Danh mục: " + categories.get(position).category_name;
                Intent chooseProductIntent = new Intent(v.getContext() , ChooseProduct.class);
                v.getContext().startActivity(chooseProductIntent);
                ((Activity)v.getContext()).finish();
            }
        });


    }

    @Override
    public int getItemCount() {
        return categories.size();
    }

    @Override
    public Filter getFilter() {
        return categoriesFilter;
    }


    public static String deAccent(String str) {
        String nfdNormalizedString = Normalizer.normalize(str, Normalizer.Form.NFD);
        Pattern pattern = Pattern.compile("\\p{InCombiningDiacriticalMarks}+");
        return pattern.matcher(nfdNormalizedString).replaceAll("");
    }

    private Filter categoriesFilter = new Filter() {
        @Override
        protected FilterResults performFiltering(CharSequence constraint) {
            List<Category> filteredCategories = new ArrayList<>();
            if (constraint == null || constraint.length() == 0){
                filteredCategories.addAll(categoriesAll);
            }
            else {
                String filterPattern = constraint.toString().toLowerCase().trim();

                for (Category category : categories ) {
                    if (deAccent(category.category_name.toLowerCase()).contains(deAccent(filterPattern))) {
                        filteredCategories.add(category);
                    }

                }
            }
            FilterResults results = new FilterResults();
            results.values = filteredCategories;
            return results;
        }

        @Override
        protected void publishResults(CharSequence constraint, FilterResults results) {
            categories.clear();
            categories.addAll((List) results.values);
            notifyDataSetChanged();
        }
    };

    public class ViewHolder extends RecyclerView.ViewHolder {
        TextView txtCategoryName;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            txtCategoryName = itemView.findViewById(R.id.txtDiscountCode);
        }
    }
}

